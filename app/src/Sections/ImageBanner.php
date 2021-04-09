<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class ImageBanner extends Section
    {
        private static $singular_name = 'Image Banner';

        private static $db = [
            'Content'         => 'HTMLText',
            'ContentPosition' => 'Varchar',
            'ImageAnimation'  => 'Varchar',
            'ImageOverlay'    => 'Varchar',
            'ImageHeight'     => 'Varchar',
            'IsParallax'      => 'Boolean',
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        private static $defaults = [
            'ImageHeight' => 'large'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Banner image')
                ->setFolderName('Banner/Images'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('IsParallax', 'Enable image parallax'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ImageHeight', 'Image height',
                array(
                    'small' => 'Small',
                    'medium'=> 'Medium',
                    'large' => 'Large'
                )
            ));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'left-content'   => 'Left',
                    'center-content' => 'Center',
                    'right-content'  => 'Right'
                )
            ));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ImageOverlay', 'Add image overlay',
                array(
                    'none' => 'None',
                    'dark' => 'Dark',
                    'light'=> 'Light'
                )
            ));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ImageAnimation', 'Animation',
                Animation::get()->filter('Archived', false)->map('Name', 'Name')));
        }
    }
}
