<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataExtension;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

    class MemberExtension extends DataExtension
    {
        private static $db = [
            'Position' => 'Text',
            'Bio' => 'HTMLText',
        ];

        private static $has_one = [
            'ProfileImage' => Image::class
        ];

        private static $has_many = [
            'Socials' => Socials::class
        ];

        private static $owns = [
            'ProfileImage'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', TextField::create('Position'));
            $fields->addFieldToTab('Root.Main', $image = UploadField::create('ProfileImage'),'Locale');
                $image->setFolderName('Member/ProfileImages');
                $image->setAllowedExtensions(['png','gif','jpeg','jpg']);

            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Bio'),'Locale');

            $gridConfig = GridFieldConfig_RecordEditor::create(9999);
            if ($this->owner->Socials()->Count()) {
                $gridConfig->addComponent(new GridFieldSortableRows('Sort'));
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }
                ]
            ]);

            $gridField = GridField::create(
                'Socials',
                'Socials',
                $this->owner->Socials(),
                $gridConfig
            );

            $fields->addFieldToTab('Root.Socials', $gridField,'Locale');
        }
    }
}
