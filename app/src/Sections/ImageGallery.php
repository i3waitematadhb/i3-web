<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

    class ImageGallery extends Section
    {
        private static $singular_name = 'Image Gallery';

        private static $has_many = [
            'Images' => ImageItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(9999);
            if ($this->Images()->Count()) {
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
                'Images',
                'Images',
                $this->Images(),
                $gridConfig
            );

            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleImageItems()
        {
            return $this->Images()->filter('Archived', false)->sort('Sort');
        }
    }
}
