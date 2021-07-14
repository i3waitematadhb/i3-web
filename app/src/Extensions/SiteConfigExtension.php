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
            'SiteLogo'    => File::class,
            'SiteLogoDark'=> File::class,
            'AltSiteLogo' => File::class
        ];

        private static $owns = [
            'SiteLogo',
            'SiteLogoDark',
            'AltSiteLogo'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            /*
             *  Header
             */
            $fields->addFieldToTab('Root.Header', UploadField::create('SiteLogo')->setFolderName('SiteLogo'));
            $fields->addFieldToTab('Root.Header', UploadField::create('SiteLogoDark', 'Site logo dark')->setFolderName('SiteLogo'));
            $fields->addFieldToTab('Root.Header', UploadField::create('AltSiteLogo', 'Site logo alt')->setFolderName('SiteLogo'));
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
             *  Section Width
             */
            $configWidth = GridFieldConfig_RecordEditor::create('999');
            $editorWidth = GridField::create('SectionWidth', 'Width', SectionWidth::get(), $configWidth);
            $fields->addFieldToTab('Root.Sections', $editorWidth);

            /*
             *  Padding
             */
            $configPadding = GridFieldConfig_RecordEditor::create('999');
            $editorPadding = GridField::create('Padding', 'Padding', Padding::get(), $configPadding);
            $fields->addFieldToTab('Root.Sections', $editorPadding);

            /*
             *  Mobile Padding
             */
            $configMobilePadding = GridFieldConfig_RecordEditor::create('999');
            $editorMobilePadding = GridField::create('MobilePadding', 'Mobile padding', MobilePadding::get(), $configMobilePadding);
            $fields->addFieldToTab('Root.Sections', $editorMobilePadding);

            /*
             * Footer Items
             */
            $configFooter = GridFieldConfig_RecordEditor::create('999');
            $editorFooter = GridField::create('Footer', 'Footer', FooterItems::get(), $configFooter);
            $fields->addFieldToTab('Root.Footer', $editorFooter);
        }
    }
}
