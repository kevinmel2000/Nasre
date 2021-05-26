<?php
return [
	// whenever you add a new module name in the MODULES array, remember to add its functionality in the 
	// PermissionsController index, permissionsByUser and getPermissionsByUser methods
	// and respective middleware route in the routes.  
	'MODULES'=>[
					'contact_module', 
					'role_module', 
					'user_module', 
					// 'lead_module', 
					// 'product_module', 
					// 'office_module',
					'country_module',
					'occupation_module',
					'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'golf_field_hole_module',
                    'ceding_broker_module',
                    'lookup_location_module',
                    'city_module',
                    'state_module',
                    'earthquake_zone_module',
                    'flood_zone_module',
                    'ship_type_module',
                    'classification_module',
                    'construction_module',
					'marine_lookup_module',
					'property_type_module',
					'condition_needed_module',
					'cause_of_loss_module',
					'company_type_module',
					'interest_insured_module',
					'prefix_insured_module',
					'route_module',
					'ship_port_module',
					'nature_of_loss_module',
					'surveyor_module',
					'location_master_module',
					'marine_master_module',
					'deductible_panel_module',
					'extend_coverage_module',
				],
	
	'CONTACT_TYPES' => ['Customer','Past-Customer','Non-Customer'],
	'PROSPECTS' => ['Prospect','Lost-Prospect','Non-Prospect'],
];
?>