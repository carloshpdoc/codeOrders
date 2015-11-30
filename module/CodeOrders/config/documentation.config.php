<?php
return array(
    'CodeOrders\\V1\\Rest\\Ptypes\\Controller' => array(
        'description' => 'Handles payment types',
        'collection' => array(
            'description' => 'Collection of payment types',
            'GET' => array(
                'description' => 'List all payment types',
                'response' => '{
   "_links": {
       "self": {
           "href": "/ptypes"
       },
       "first": {
           "href": "/ptypes?page={page}"
       },
       "prev": {
           "href": "/ptypes?page={page}"
       },
       "next": {
           "href": "/ptypes?page={page}"
       },
       "last": {
           "href": "/ptypes?page={page}"
       }
   }
   "_embedded": {
       "ptypes": [
           {
               "_links": {
                   "self": {
                       "href": "/ptypes[/:ptypes_id]"
                   }
               }
              "name": "Name of payment type"
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a new payment type',
                'request' => '{
"id": "id of payment type",  
 "name": "Name of payment type"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/ptypes[/:ptypes_id]"
       }
   }
   "id": "id of payment type",
   "name": "Name of payment type"
}',
            ),
        ),
        'entity' => array(
            'description' => 'PaymentTypes',
            'GET' => array(
                'description' => 'Return a payment type',
                'response' => '{
   "_links": {
       "self": {
           "href": "/ptypes[/:ptypes_id]"
       }
   }
 "id": "id of payment type",
   "name": "Name of payment type"
}',
            ),
            'PATCH' => array(
                'description' => 'Update partialy of payment type',
                'request' => '{
 "id": "id of payment type",
   "name": "Name of payment type"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/ptypes[/:ptypes_id]"
       }
   }
 "id": "id of payment type",
   "name": "Name of payment type"
}',
            ),
        ),
    ),
);
