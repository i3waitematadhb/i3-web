<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class VideoBanner extends Section
    {
        private static $singular_name = 'Video Banner';

        private static $db = [
            'Content'         => 'HTMLText',
            'ContentPosition' => 'Varchar'
        ];

        private static $has_one = [
            'ExtraImage' => File::class,
            'Video' => File::class
        ];

        private static $owns = [
            'ExtraImage',
            'Video'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Video', 'Banner video')
                ->setFolderName('Banner/Videos'));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'left-content'   => 'Left',
                    'center-content' => 'Center',
                    'right-content'  => 'Right'
                )
            ));
            $fields->addFieldToTab('Root.Main', UploadField::create('ExtraImage')
                ->setFolderName('Banner/ExtraImages'));
        }
    }
}
