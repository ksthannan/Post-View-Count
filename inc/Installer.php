<?php 
namespace WedevsAcademy\WpPostViewCount;

// Class Installer
class Installer{
    public function run()
    {
        $this->add_version();
    }

    public function add_version()
    {
        $installed = get_option('postvc_installed');

        if (!$installed) {
            update_option('postvc_installed', time());
        }

        update_option('postvc_version', POSTVC_VER);

    }
}