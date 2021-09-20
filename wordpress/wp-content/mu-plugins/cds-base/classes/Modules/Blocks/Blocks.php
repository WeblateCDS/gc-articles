<?php
namespace CDS\Modules\Blocks;
class Blocks
{
    
    protected $version;
    
    public function __construct()
    {
        $this->register();
        $this->version = "1.0.0";
        add_action('admin_enqueue_scripts', [$this, 'addStyles'], 10, 2);
    }

    public function register(){
        /* blocks */
        register_block_type('cds-snc/expander', [
            'editor_script' => 'cds-snc',
        ]);

        register_block_type('cds-snc/alert', [
            'editor_script' => 'cds-snc',
        ]);

        /* table styles */
        register_block_style('core/table', [
            'name' => 'bordered-table',
            'label' => 'Bordered Table',
        ]);

        register_block_style('core/table', [
            'name' => 'filterable',
            'label' => 'Filterable Table',
        ]);

        register_block_style('core/table', [
            'name' => 'responsive-cards',
            'label' => 'Responsive Cards Table',
        ]);

        if (function_exists('wp_set_script_translations')) {
            /**
             * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
             * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
             * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
             */
            wp_set_script_translations('cds-snc-base', 'cds-snc');
        }
    }

    public function addStyles(){
        // add stylesheet to the wp admin
        wp_enqueue_style(
            'cds-base-block-alert',
            plugin_dir_url(__FILE__) . 'src/alert/alert.css',
            [],
            $this->version,
        );
    }
}