<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class Card extends Section
    {
        private static $singular_name = 'Card';

        private static $has_many = [
            'Cards' => CardItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->Cards()->Count())
            {
                $gridConfig->addComponent(new GridFieldOrderableRows());
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'CardWidth' => [
                    'title' => 'Card Width',
                    'callback' => function($record, $column, $grid) {
                        $fields = DropdownField::create($column, $column, SectionWidth::get()->filter('Archived', false)->map('Class','Name'));
                        return $fields;
                    }
                ],
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }]
            ]);

            $gridField = GridField::create(
                'Cards',
                'Cards',
                $this->Cards(),
                $gridConfig
            );

            $fields->removeByName("Cards");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleCardItems()
        {
            return $this->Cards()->filter('Archived', false)->sort('Sort');
        }
    }
}
