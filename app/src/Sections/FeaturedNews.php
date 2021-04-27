<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class FeaturedNews extends Section
    {
        private static $singular_name = 'Featured News';

        private static $db = [
            'Content' => 'HTMLText',
            'ContentPosition' => 'Varchar'
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'content-left' => 'Position left',
                    'content-right'=> 'Position Right'
                )
            ));
            $fields->addFieldToTab('Root.Main', UploadField::create('Image')
                ->setFolderName('Sections/Section_FeaturedNews/Images'));
        }
    }
}
