<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class History extends Section
    {
        private static $singular_name = 'History';

        private static $has_many = [
            'HistoryItems' => HistoryItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->HistoryItems()->Count())
            {
                $gridConfig->addComponent(new GridFieldOrderableRows());
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }]
            ]);

            $gridField = GridField::create(
                'HistoryItems',
                'History',
                $this->HistoryItems(),
                $gridConfig
            );

            $fields->removeByName("HistoryItems");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleHistoryItems()
        {
            return $this->HistoryItems()->filter('Archived', false)->sort('Sort');
        }
    }
}
