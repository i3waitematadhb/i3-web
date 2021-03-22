<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
    use TractorCow\SliderField\SliderField;

    class ProjectList extends Section
    {
        private static $singular_name = 'Project List';

        private static $db = [
            'NumPerRow'   => 'Int',
        ];

        private static $has_one = [
            'Page' => SiteTree::class
        ];

        private static $has_many = [
            'ProjectListItems' => ProjectListItems::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', SliderField::create('NumPerRow', 'Projects per row', 2, 4));
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->ProjectListItems()->Count())
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
                'ProjectListItems',
                'Project Lists',
                $this->ProjectListItems(),
                $gridConfig
            );

            $fields->removeByName("ProjectListItems");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleProjectListItems()
        {
            return $this->ProjectListItems()->filter('Archived', false)->sort('Sort');
        }

        public function widthSize($rowLimit){
            if ($rowLimit == '2')  {
                return  'col-md-6';
            } elseif ($rowLimit == '3') {
                return 'col-md-4';
            } else {
                return 'col-md-3';
            }
        }
    }
}
