<?php

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys (dovy)
 * @version     3.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_Extension_custom_field' ) ) {


    /**
     * Main ReduxFramework custom_field extension class
     *
     * @since       3.1.6
     */
    class ReduxFramework_Extension_custom_field extends Redux_Extension_Abstract {
        
        // Set the version number of your extension here
        public static $version       = '1.0.0';
        // Set the name of your extension here
        public $ext_name             = 'Custom Font';
        public $min_redux_version    = '3.0.0';
        public $upload_dir = '';
        public $upload_url = '';
        public $custom_field = array('url'=>'','name'=>'');
        public static $instance = null;

        /**
        * Class Constructor. Defines the args for the extions class
        *
        * @since       1.0.0
        * @access      public
        * @param       array $sections Panel sections.
        * @param       array $args Class constructor arguments.
        * @param       array $extra_tabs Extra panel tabs.
        * @return      void
        */
        public function __construct( $redux ) {
            parent::__construct( $redux, __FILE__ );
            $this->add_field( 'custom_field' );
            self::$instance = parent::get_instance();

            $this->upload_dir = Redux_Core::$upload_dir . 'custom-fonts/';
            $this->upload_url = wp_upload_dir()['baseurl'] . '/redux/custom-fonts/';



            if ( ! is_dir( $this->upload_dir ) ) {
                $this->parent->filesystem->execute( 'mkdir', $this->upload_dir );
            }

            if ( ! is_dir( $this->upload_dir . '/custom' ) ) {
                $this->parent->filesystem->execute( 'mkdir', $this->upload_dir . '/custom' );
            }
            
            add_action('wp_ajax_redux_custom_field', array( $this, 'ajax' ));
            add_filter( "redux/{$this->parent->args['opt_name']}/field/custom_field", array( $this, 'add_custom_field'));

            add_filter( 'upload_mimes', array( $this, 'custom_upload_mimes' ) );
        }

        public function getInstance() {
            return self::$instance;
        }

        public function add_custom_field( $custom_field ): array {
            if ( empty( $custom_field ) ) {
                $custom_field = hitsxyz_get_theme_options('hits_custom_font_ttf');
            }

            return wp_parse_args( $custom_field, $this->custom_field );
        }


        public function custom_upload_mimes( array $existing_mimes = array() ): array {
            $existing_mimes['ttf']   = 'font/ttf';

            return $existing_mimes;
        }

        public function get_fonts() {
            if ( empty( $this->custom_field ) ) {
                $params = array('include_hidden' => false,'recursive' => true,);

                $fonts = $this->parent->filesystem->execute( 'dirlist', $this->upload_dir, $params );

                if ( ! empty( $fonts ) ) {
                    foreach ( $fonts as $section ) {
                        if ( 'd' === $section['type'] && ! empty( $section['name'] ) ) {
                            if ( 'custom' === $section['name'] ) {
                                $section['name'] = esc_html__( 'Custom Fonts', 'redux-framework' );
                            }

                            if ( empty( $section['files'] ) ) {
                                continue;
                            }

                            $this->custom_field[ $section['name'] ] = $this->custom_field[ $section['name'] ] ?? array();

                            foreach ( $section['files'] as $font ) {
                                if ( ! empty( $font['name'] ) ) {
                                    if ( empty( $font['files'] ) ) {
                                        continue;
                                    }

                                    $kinds = array();

                                    foreach ( $font['files'] as $f ) {
                                        $valid = $this->check_font_name( $f );
                                        if ( $valid ) {
                                            $kinds[] = $valid;
                                        }
                                    }

                                    $this->custom_field[ $section['name'] ][ $font['name'] ] = $kinds;
                                }
                            }
                        }
                    }
                }
            }
        }


        private function check_font_name( array $file ) {
            if ( '.woff' === strtolower( substr( $file['name'], - 5 ) ) ) {
                return 'woff';
            }

            if ( '.woff2' === strtolower( substr( $file['name'], - 6 ) ) ) {
                return 'woff2';
            }

            $sub = strtolower( substr( $file['name'], - 4 ) );

            if ( '.ttf' === $sub ) {
                return 'ttf';
            }

            if ( '.eot' === $sub ) {
                return 'eot';
            }

            if ( '.svg' === $sub ) {
                return 'svg';
            }

            if ( '.otf' === $sub ) {
                return 'otf';
            }

            return false;
        }

        public function ajax() {
            $result = array();
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'redux_custom_field' ) ) {
                $result = array( 'type' => 'error', 'msg'=> 'error none' );
                echo wp_json_encode( $result );
                die( 0 );
            }


            if ( isset( $_POST['type'] ) || 'delete' === $_POST['type'] ) {
                
                try {
                    if (isset( $_POST['name'] ) ) {
                        $this->parent->filesystem->execute( 'rmdir', $this->upload_dir . 'custom/' . sanitize_title( wp_unslash( $_POST['name'] ) ) . '/', array( 'recursive' => true ) );

                        $result = array( 'type' => 'success' );
                    }
                } catch ( Exception $e ) {
                    $result = array(
                        'type' => 'error',
                        'msg'  => esc_html__( 'Unable to delete font file(s).', 'redux-framework' ),
                    );
                }
            } else {
                if ( ! isset( $_POST['title'] ) ) {
                    $_POST['title'] = '';
                }

                if ( ! isset( $_POST['filename'] ) ) {
                    $_POST['filename'] = '';
                }

                if ( ! empty( $_POST['attachment_id'] ) ) {
                    if ( isset( $_POST['title'] ) || isset( $_POST['mime'] ) ) {

                        $msg = $this->process_web_font( sanitize_key( wp_unslash( $_POST['attachment_id'] ) ), sanitize_text_field( wp_unslash( $_POST['title'] ) ), sanitize_text_field( wp_unslash( $_POST['filename'] ) ), sanitize_text_field( wp_unslash( $_POST['mime'] ) ) );

                        if ( empty( $msg ) ) {
                            $msg = '';
                        }

                        $result = array(
                            'type' => 'success',
                            'msg'  => $msg,
                            'name' => $_POST['title'],
                            'urlfont' => sanitize_text_field($this->upload_url .'custom/'.$_POST['title'].'/'.$_POST['filename'])
                        );
                    }
                }
            }
            echo wp_json_encode( $result, JSON_UNESCAPED_SLASHES);
            die();
        }
        public function process_web_font( string $attachment_id, string $name, string $true_filename, string $mime_type ) {
            // phpcs:ignore WordPress.Security.NonceVerification
            if ( ! isset( $_POST['conversion'] ) ) {
                $_POST['conversion'] = 'false';
            }

            // phpcs:ignore WordPress.Security.NonceVerification
            $conversion = sanitize_text_field( wp_unslash( $_POST['conversion'] ) );

            $missing = array();

            $complete = array(
                'ttf',
                'woff',
                'woff2',
                'eot',
                'svg',
                'otf',
            );

            $subfolder = 'custom/';
            $subtype   = explode( '/', $mime_type );
            $subtype   = trim( max( $subtype ) );

            if ( ! is_dir( $this->upload_dir ) ) {
                $this->parent->filesystem->execute( 'mkdir', $this->upload_dir );
            }

            if ( ! is_dir( $this->upload_dir . $subfolder ) ) {
                $this->parent->filesystem->execute( 'mkdir', $this->upload_dir . $subfolder );
            }

            $temp = $this->upload_dir . 'temp';
            $path = get_attached_file( $attachment_id );

            if ( empty( $path ) ) {
                echo wp_json_encode(
                    array(
                        'type' => 'error',
                        'msg'  => esc_html__( 'Attachment does not exist.', 'redux-framework' ),
                    )
                );

                die();
            }

            $filename = explode( '/', $path );

            $filename = $filename[ ( count( $filename ) - 1 ) ];

            $fontname = ucfirst(
                str_replace(
                    array(
                        '.zip',
                        '.ttf',
                        '.woff',
                        '.woff2',
                        '.eot',
                        '.svg',
                        '.otf',
                    ),
                    '',
                    strtolower( $filename )
                )
            );

            if ( empty( $name ) ) {
                $name = $fontname;
            }

            $ret = array();

            if ( ! is_dir( $temp ) ) {
                $this->parent->filesystem->execute( 'mkdir', $temp );
            }

            if ( 'svg+xml' === $subtype || 'vnd.ms-fontobject' === $subtype || 'x-font-ttf' === $subtype || 'ttf' === $subtype || 'otf' === $subtype || 'font-woff' === $subtype || 'font-woff2' === $subtype || 'application-octet-stream' === $subtype || 'octet-stream' === $subtype ) {
                foreach ( $complete as $test ) {
                    if ( $subtype !== $test ) {
                        if ( ! isset( $output[ $test ] ) ) {
                            $missing[] = $test;
                        }
                    }
                }

                if ( ! is_dir( $this->upload_dir . $subfolder . $name . '/' ) ) {
                    $this->parent->filesystem->execute( 'mkdir', $this->upload_dir . $subfolder . $name . '/' );
                }

                $output = array( $subtype => $path );

                // TODO: COnversion error not moving single file.
                $param_array = array(
                    'destination' => $this->upload_dir . $subfolder . '/' . $name . '/' . $true_filename, // $fontname . '.' . $subtype,
                    'overwrite'   => true,
                    'chmod'       => 0644,
                );

                $this->parent->filesystem->execute( 'copy', $path, $param_array );
                $this->parent->filesystem->execute( 'rmdir', $temp, array( 'recursive' => true ) );

                wp_delete_attachment( $attachment_id, true );
            } else {
                echo wp_json_encode(
                    array(
                        'type' => 'error',
                        'msg'  => esc_html__( 'File type not recognized.', 'redux-framework' ) . ' ' . $subtype,
                    )
                );

                die();
            }

            return '';
        }

    }
}
