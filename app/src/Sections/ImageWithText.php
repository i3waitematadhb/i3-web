<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use TractorCow\Colorpicker\Color;

    class ImageWithText extends Section
    {
        private static $singular_name = 'Image With Text';

        private static $db = [
            'Content'            => 'HTMLText',
            'ContentPosition'    => 'Varchar',
            'GradientBackground' => 'Boolean'
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
                $image->setFolderName('Sections/Section_ImageWithText/Images');
                $image->getValidator()->setAllowedExtensions(['png','gif','jpeg','jpg']);
                $image->setDescription('For best resolution: upload 600x600 size image ');
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'position-left'  => 'Left',
                    'position-right' => 'Right'
                )
            ));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('GradientBackground', 'Enable gradient background color'));
        }
    }
}
