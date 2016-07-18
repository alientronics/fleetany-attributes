<?php 

return [
    [
        'TableName'             => 'keys',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'id',
                'AttributeType' => 'N',
            ],
            [
                'AttributeName' => 'company_id',
                'AttributeType'       => 'N',
            ],
            [
                'AttributeName' => 'entity_key',
                'AttributeType'       => 'S',
            ],
            [
                'AttributeName' => 'description',
                'AttributeType'       => 'S',
            ],
            [
                'AttributeName' => 'type',
                'AttributeType'       => 'S',
            ],
            [
                'AttributeName' => 'options',
                'AttributeType'       => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'id',
                'KeyType'       => 'HASH',
            ],
            [
                'AttributeName' => 'company_id',
                'KeyType'       => 'RANGE',
            ],
        ],
        'GlobalSecondaryIndexes' => [
            [
                'IndexName' => 'index_name_1',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'entity_key',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'KEYS_ONLY',
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
            [
                'IndexName' => 'index_name_2',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'description',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'KEYS_ONLY',
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
            [
                'IndexName' => 'index_name_3',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'type',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'KEYS_ONLY',
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
            [
                'IndexName' => 'index_name_4',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'options',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'KEYS_ONLY',
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => 10,
            'WriteCapacityUnits' => 20,
            'OnDemand'           => false,
        ],
    ],
    [
        'TableName'             => 'values',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'id',
                'AttributeType' => 'N',
            ],
            [
                'AttributeName' => 'entity_key',
                'AttributeType'       => 'S',
            ],
            [
                'AttributeName' => 'entity_id',
                'AttributeType'       => 'N',
            ],
            [
                'AttributeName' => 'attribute_id',
                'AttributeType'       => 'N',
            ],
            [
                'AttributeName' => 'value',
                'AttributeType'       => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'id',
                'KeyType'       => 'HASH',
            ],
            [
                'AttributeName' => 'entity_key',
                'KeyType'       => 'RANGE',
            ],
        ],
        'GlobalSecondaryIndexes' => [
            [
                'IndexName' => 'index_name_1',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'entity_id',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'INCLUDE',
                    'NonKeyAttributes' => [
                        'entity_id',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
            [
                'IndexName' => 'index_name_2',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'attribute_id',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'INCLUDE',
                    'NonKeyAttributes' => [
                        'attribute_id',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
            [
                'IndexName' => 'index_name_3',
                'KeySchema' => [
                    [
                        'AttributeName' => 'id',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'value',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'Projection' => [
                    'ProjectionType' => 'INCLUDE',
                    'NonKeyAttributes' => [
                        'value',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1,
                ],
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => 10,
            'WriteCapacityUnits' => 20,
            'OnDemand'           => false,
        ],
    ]
];