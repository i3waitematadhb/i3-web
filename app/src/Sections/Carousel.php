<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class Carousel extends Section
    {
        private static $singular_name = 'Carousel';

        private static $db = [

        ];

        private static $has_many = [
            'CarouselItems' => CarouselItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->CarouselItems()->Count())
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
                'CarouselItems',
                'Carousel',
                $this->CarouselItems(),
                $gridConfig
            );

            $fields->removeByName("CarouselItems");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleCarouselItems()
        {
            return $this->CarouselItems()->filter('Archived', false)->sort('Sort');
        }
    }
}
