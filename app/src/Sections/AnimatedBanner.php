<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class AnimatedBanner extends Section
    {
        private static $singular_name = 'Animated Banner';

        private static $db = [
        ];

        private static $has_many = [
            'AnimatedItems' => AnimatedItem::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->AnimatedItems()->Count())
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
                'AnimatedItems',
                'Animated Items',
                $this->AnimatedItems(),
                $gridConfig
            );

            $fields->removeByName("AnimatedItems");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleAnimatedItems()
        {
            return $this->AnimatedItems()->filter('Archived', false)->sort('Sort');
        }
    }
}
