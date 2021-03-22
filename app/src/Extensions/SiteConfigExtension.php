<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataExtension;
    use TractorCow\SliderField\SliderField;

    class SiteConfigExtension extends DataExtension
    {
        private static $db = [
            'SiteLogoWidth'    => 'Int',
            'SiteLogoPosition' => 'Varchar'
        ];

        private static $has_one = [
            'SiteLogo' => File::class
        ];

        private static $owns = [
            'SiteLogo'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            /*
             *  Header
             */
            $fields->addFieldToTab("Root.Header", UploadField::create("SiteLogo")->setFolderName('SiteLogo'));
            $fields->addFieldToTab('Root.Header', SliderField::create('SiteLogoWidth', 'Site logo width', '50', '350'));
            $fields->addFieldToTab('Root.Header', DropdownField::create('SiteLogoPosition', 'Site logo position',
                array(
                    'position-left'  => 'Left',
                    'position-center'=> 'Centered',
                    'position-right' => 'Right'
                )
            ));

            /*
             *  Animation
             */
            $configAnimation = GridFieldConfig_RecordEditor::create('999');
            $editorAnimation = GridField::create('Animation', 'Animation', Animation::get(), $configAnimation);
            $fields->addFieldToTab('Root.Animation', $editorAnimation);

            /*
             * Footer Items
             */
            $configFooter = GridFieldConfig_RecordEditor::create('999');
            $editorFooter = GridField::create('Footer', 'Footer', FooterItems::get(), $configFooter);
            $fields->addFieldToTab('Root.Footer', $editorFooter);
        }
    }
}
