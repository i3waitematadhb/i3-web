<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

    class Accordion extends Section
    {
        private static $singular_name = 'Accordion';

        private static $has_many = [
            'Accordions' => AccordionItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(9999);
            if ($this->Accordions()->Count()) {
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
                'Accordions',
                'Accordions',
                $this->Accordions(),
                $gridConfig
            );

            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleAccordionItems()
        {
            return $this->Accordions()->filter('Archived', false)->sort('Sort');
        }
    }
}
