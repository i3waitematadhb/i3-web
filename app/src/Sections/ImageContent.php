<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;

    class ImageContent extends Section
    {
        private static $singular_name = 'Image';

        private static $db = [
            'ImageHeight'    => 'Varchar',
            'ImageAnimation' => 'Varchar',
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        private static $defaults = [
            'ImageHeight' => 'ih-large'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image', 'Banner image'));
            $image->setFolderName('Sections/Section_Banner/Images');
            $image->setAllowedExtensions(['png','gif','jpeg','jpg']);
            $fields->addFieldToTab('Root.Main', DropdownField::create('ImageHeight', 'Image height',
                array(
                    'ih-small' => 'Small',
                    'ih-medium'=> 'Medium',
                    'ih-large' => 'Large'
                )
            ));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ImageAnimation', 'Animation',
                Animation::get()->filter('Archived', false)->map('Name', 'Name')));

        }
    }
}
