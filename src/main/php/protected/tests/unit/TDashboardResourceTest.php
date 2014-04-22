<?php
/**
 * TDashboardResourceTest
 *
 * @uses PHPUnit
 * @uses _Framework_testCase
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author James Njoroge <james@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings functionNaming
 * @SuppressWarnings docBlocks
 * @SuppressWarnings lineLength
 */
class TDashboardResourceTest extends PHPUnit_Framework_TestCase {

	const WIDGETID = 'widget235';
	const GET_INFO_RETURN_VALUE = 200;
	const EXTENSION_NAME = 'GEOLOCATION';
	const ERROR_MESSAGE = 'Error 401';
	const ERRORCODE = 401;

	private $dashboardResource;
	private $dashboard;
	private $mds;
	private $userElementResult;
	private $callCount;
	private $orgElementResult;
	private $testGetDashboardParamsResult;
	private $level;
	private $triggerError;
	private $locationResult;
	private $ldap;
	private $tix;
	private $fetchGeoloc;

	/**
	 * setUp Runs before each test
	 */
	public function setUp() {
		$this->callCount = 0;
		$this->level = 2;
		$this->triggerError = false;
		$this->fetchGeoloc = true;
		Yii::app()->session->add('usersMdsElement', 'urn:tracetracker:0800002873:story:users:patjayke@gmail.com');
		Yii::app()->session->add('selectedNodeId', '0800002873000013');
		Yii::app()->session->add('currentDashboardLayout', 'default');
		Yii::app()->session->add('newDn', 'ou=People , dc=tracetracker,dc=com');
		$userGroups = array('ROLE_ADMIN', 'ROLE_MANAGER',  'ROLE_WORKER', 'ROLE_API', 'ROLE_SUPERADMIN');
		Yii::app()->session->add('userGroups', $userGroups);
		Yii::app()->session->add('currentTix', array( '0800002873000013' => 'https://alpha.tracetracker.com:8643/tix' ) );
		Yii::app()->session->add('tixUrl', array(
				'0800000033' => 'https://alpha.tracetracker.com:8643/tix',
				'0800001403' => 'https://alpha.tracetracker.com:8643/tix',
				'0800002819' => 'https://alpha.tracetracker.com:8643/tix'
			)
		);
		$businessRules = array(
			'id' => 'urn:tracetracker:story:rolemanagement:mgmtRoles',
			'showAdminColumns' => 'ROLE_TTADMIN',
			'showPartners' => 'ROLE_SUPERADMIN,ROLE_TTADMIN',
			'showInternal' => 'ROLE_SUPERADMIN,ROLE_TTADMIN',
			'showUid' => 'ROLE_TTADMIN',
			'showGTNET' => 'ROLE_TTADMIN'
		);
		Yii::app()->session->add('businessRules', $businessRules);
		$this->dashboard = Yii::app()->dashboardresource;
		$_SERVER['SERVER_NAME'] = "localhost";
		$this->orgIds = array('0800000033', '0800001403', '0800002819');
		$this->orgIdString = '0800000033,0800001403,0800002819';
		$this->userElementResult = new stdClass();
		$this->userElementResult->error = null;
		$this->userElementResult->result = array(
			array(
				'id' => 'urn:tracetracker:0800002873:story:users:patjayke@gmail.com',
				'dateFormat' => 'c',
				'lastUsedNode' => '0800002873000013',
				'0800002873000013.default' => '"{\"result\":{\"layout\": \"layout2\", \"data\" : [{\"title\" : \"Shipments\", \"id\" : \"widget236\", \"column\" : \"first\",\"editurl\" : \"undefined\",\"open\" : false,\"url\" : \"..\/shipmentsWidget\/index\/id\/widget236\",\"fullscreen\" :false,\"metadata\":{\"title\":\"Shipments\",\"rangeType\":\"static\",\"fromInterval\":\"6\",\"fromDMY\":\"m\",\"dateFrom\":\"13-03-2013\",\"dateTo\":\"13-09-2013\",\"dateSortOrder\":\"asc\",\"defaultTab\":\"0\",\"defaultPageSize\":\"25\",\"incomingTradingPartner\":\"All\",\"outgoingTradingPartner\":\"All\"}},{\"title\" : \"Shipments\", \"id\" : \"widget235\", \"column\" : \"first\",\"editurl\" : \"undefined\",\"open\" : true,\"url\" : \"..\/shipmentsWidget\/index\/id\/widget235\",\"fullscreen\" :false,\"metadata\":{\"title\":\"Shipments\",\"rangeType\":\"dynamic\",\"fromInterval\":\"6\",\"fromDMY\":\"m\",\"dateFrom\":\"13-03-2013\",\"dateTo\":\"13-09-2013\",\"dateSortOrder\":\"asc\",\"defaultTab\":\"0\",\"defaultPageSize\":\"25\",\"incomingTradingPartner\":\"All\",\"outgoingTradingPartner\":\"All\"}}]}}"',
				'0800002873000013.lastUsedDashboard' => '0800002873000013.default',
				'serialNo' => 241
				)

		);
		$this->instanceElementResult = new stdClass();
		$this->instanceElementResult->error = null;
		$this->instanceElementResult->result = array(
			array(
					'id' => 'urn:tracetracker:story:config:shipmentsWidget',
					'title' => 'Shipments',
					'image' => '../../images/shipmentsWidget.png',
					'creator' => 'James',
					'categoryId' => 'urn:tracetracker:story:dashboardCategories:1',
					'description' => 'Shipments between two locations',
					'url' => 'shipmentsWidget'
				)

		);
		$this->orgElementResult = new stdClass();
		$this->orgElementResult->error = null;
		$this->orgElementResult->result = array(
			array(
					'id' => 'urn:tracetracker:0800002873:story:config:shipmentsWidget',
					'outgoingProductNameProperty' => 'product_name',
					'productLookupType' => 'tix',
					'incomingProductNameProperty' => 'product_name'
				)
		);
		// print_r(new DateTime('2013-03-25 00:00:00')); die();
		$this->testGetDashboardParamsResult = array(
			'title' => 'Shipments',
			'image' => '../../images/shipmentsWidget.png',
			'creator' => 'James',
			'categoryId' => 'urn:tracetracker:story:dashboardCategories:1',
			'description' => 'Shipments between two locations',
			'url' => 'shipmentsWidget',
			'outgoingProductNameProperty' => 'product_name',
			'productLookupType' => 'tix',
			'incomingProductNameProperty' => 'product_name',
			'rangeType' => 'dynamic',
			'fromInterval' => '6',
			'fromDMY' => 'm',
			'dateSortOrder' => 'asc',
			'defaultTab' => '0',
			'defaultPageSize' => '25',
			'incomingTradingPartner' => 'All',
			'outgoingTradingPartner' => 'All'
		);
		// print_r(new DateTime(date('d-m-Y', strtotime('-6 months')))); die();
		$this->testGetDashboardParamsResult['dateFrom'] = new DateTime(date('d-m-Y', strtotime('-6 months')));
		$this->testGetDashboardParamsResult['dateTo'] = new DateTime(date('d-m-Y'));
		$this->testGetDashboardParamsResult['dateTo']->add(new DateInterval('PT23H59M59S'));
		$this->extensionQueryResult = new stdClass();
		$this->extensionQueryResult->error = null;
		$this->extensionQueryResult->result = array( 
			array( 
				'id' => 'urn:tracetracker:0800002873000013:story:config:extensionsFields:geo_point',
				'type' => 'GEOLOCATION',
				'namespace' => 'urn:tracetracker:epcis'
			) 
		); 

		$this->locationResult = new stdClass();
		$this->locationResult->error = null;
		$this->locationResult->result = array(
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.2622.*',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-07',
				'urn:tracetracker:asset:mda:latlon_point' => '63.3935,10.4012',
				'urn:tracetracker:asset:mda:loc_resp' => 'TO',
				'urn:tracetracker:asset:mda:loc_active' => '1',
				'urn:tracetracker:asset:mda:loc_dept' => '10',
				'urn:tracetracker:asset:mda:loc_name' => "Haakon VII's gt - Ny veiprofil og VA",
				'urn:tracetracker:asset:mda:loctype' => '0'
			),
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.1353.*',
				'urn:tracetracker:asset:mda:latlon_point' => '63.3743,10.5889',
				'urn:tracetracker:asset:mda:loc_name' => 'Skogly boligfelt',
				'urn:tracetracker:asset:mda:loc_active' => '1',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-01',
				'urn:tracetracker:asset:mda:loc_resp' => 'PKA',
				'urn:tracetracker:asset:mda:loc_dept' => '10',
				'urn:epcglobal:epcis:mda:address' => null,
				'urn:tracetracker:asset:mda:loctype' => '0'
			),
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.2624.*',
				'urn:tracetracker:asset:mda:loc_resp' => 'KSI',
				'urn:tracetracker:asset:mda:loc_active' => '1',
				'urn:tracetracker:asset:mda:loc_dept' => '10',
				'urn:tracetracker:asset:mda:loctype' => '0',
				'urn:tracetracker:asset:mda:latlon_point' => '63.4036,10.1861',
				'urn:tracetracker:asset:mda:loc_name' => 'BUP Lian - park og uteanlegg',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-07'
			),
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.1632.*',
				'urn:tracetracker:asset:mda:loctype' => '0',
				'urn:tracetracker:asset:mda:loc_dept' => '10',
				'urn:tracetracker:asset:mda:loc_res' => 'PKA',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-06',
				'urn:tracetracker:asset:mda:loc_name' => 'DELETED BY Jan Erik and Zdenek',
				'urn:tracetracker:asset:mda:latlon_point' => '63.3781,10.5211',
				'urn:tracetracker:asset:mda:loc_active' => '1'
			),
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.2631.*',
				'urn:tracetracker:asset:mda:loc_name' => 'Tipp Fesil Klæbu',
				'urn:tracetracker:asset:mda:loc_active' => '1',
				'urn:tracetracker:asset:mda:latlon_point' => '63.3906,10.8292',
				'urn:tracetracker:asset:mda:loc_resp' => 'MS',
				'urn:tracetracker:asset:mda:loctype' => '0',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-08',
				'urn:tracetracker:asset:mda:loc_dept' => '10'
			),
			array(
				'id' => 'urn:gtnet:idpat:gsli:1.1732.*',
				'urn:tracetracker:asset:mda:start_date' => '2010-12-02',
				'urn:tracetracker:asset:mda:latlon_point' => '63.3556,10.4478',
				'urn:tracetracker:asset:mda:loc_active' => '1',
				'urn:tracetracker:asset:mda:loctype' => '0',
				'urn:tracetracker:asset:mda:loc_dept' => '10',
				'urn:epcglobal:epcis:mda:address' => null,
				'urn:tracetracker:asset:mda:loc_resp' => 'PKA',
				'urn:tracetracker:asset:mda:loc_name' => 'DELETED BY Jan Erik and Zdenek'
			)
		);
		$this->locationArray = array(
			'urn:gtnet:idpat:gsli:1.2622.*' => "Haakon VII's gt - Ny veiprofil og VA",
			'urn:gtnet:idpat:gsli:1.1353.*' => 'Skogly boligfelt',
			'urn:gtnet:idpat:gsli:1.2624.*' => 'BUP Lian - park og uteanlegg',
			'urn:gtnet:idpat:gsli:1.1632.*' => 'DELETED BY Jan Erik and Zdenek',
			'urn:gtnet:idpat:gsli:1.2631.*' => 'Tipp Fesil Klæbu',
			'urn:gtnet:idpat:gsli:1.1732.*' => 'DELETED BY Jan Erik and Zdenek'
		);
		
		$this->singleLocation = new stdClass();
		$this->singleLocation->error = null;
		$this->singleLocation->result = array(
			'id' => 'urn:gtnet:idpat:gsli:1.2624.*',
			'urn:tracetracker:asset:mda:loc_resp' => 'KSI',
			'urn:tracetracker:asset:mda:loc_active' => '1',
			'urn:tracetracker:asset:mda:loc_dept' => '10',
			'urn:tracetracker:asset:mda:loctype' => '0',
			'urn:tracetracker:asset:mda:latlon_point' => '63.4036,10.1861',
			'urn:tracetracker:asset:mda:loc_name' => 'BUP Lian - park og uteanlegg',
			'urn:tracetracker:asset:mda:start_date' => '2010-12-07'
		);
		$this->gnsParentResult = new stdClass();
		$this->gnsParentResult->error = null;
		$this->gnsParentResult->result = array(
			array( 
				"id" => "urn:tracetracker:gns:organization:0800002819",
				"FN" => "Frode's fish and mermaids",
				"ON" => "frodesfish",
				"OID" => "0800002819",
				"C" => "NO",
				"LAST_MOD" => "2013-05-31T11:10:00+0200",
				"NODES" => "0800001908000013,0800001908000022,0800001908000031,0800001908000040,0800001908000068,0800001908000077,0800001908000086,
				0800001908600017,0800001908600026,0800001908600035,0800001908600044,0800001908600053,0800001908600062,0800001908600071,0800001908600080,
				0800001908600099,0800001908600105,0800001908600114,0800001908600123,0800001908600132,0800001908600141,0800001908600150,0800001908600169"
			)
		);
		$this->getOrgResult = new stdClass();
		$this->getOrgResult->error = null;
		$this->getOrgResult->result = array(
			// array(
   //              'id' => 'Additives Producer',
   //              'org-id' => '0800000015'
   //          )
			// array(
   //              'id' => 'Retailer',
   //              'org-id' => '0800000042'
   //          )
			array( 
				"id" => "urn:tracetracker:gns:organization:0800002819",
				"FN" => "TraceTracker",
				"ON" => "frodesfish",
				"OID" => "0800002819",
				"C" => "NO",
				"LAST_MOD" => "2013-05-31T11:10:00+0200"
			)
		);
		$this->orgResult = new stdClass();
		$this->orgResult->error = null;
		$this->orgResult->result = array(
			array(
				'id => urn:tracetracker:gns:organization:0800000033',
				'DUNS' => '080000003',
				'OT' => 'DSBOWNER',
				'OID' => '0800000033',
				'GLN' => '0751514000009',
				'ON' => 'no.fish',
				'TEST' => '1',
				'FN' => 'Fish Producer',
				'LAST_MOD' => '2013-08-29T17:04:21+03:00',
				'NODES' => '0800000033000013,0800000033000022,0800000033000031,0800000033000040,0800000033000059,
				0800000033000068,0800000033000077,0800000033000086',
				'C' => 'NO',
				'PO' => '0800000033'
			),
			array( 
				'id' => 'urn:tracetracker:gns:organization:0800001403',
				'FN' => 'Heinz',
				'LAST_MOD' => '2013-07-26T16:24:40+03:00',
				'ON' => 'heinz.com',
				'OID' => '0800001403',
				'GLN' => null,
				'NODES' => '0800001403000013,0800001403000022,0800001403000031',
				'C' => 'NL',
				'DUNS' => null
			), 
			array( 
				'id' => 'urn:tracetracker:gns:organization:0800002819 ',
				'FN' => 'Tracetracker',
				'DUNS' => null,
				'OID' => '0800002819',
				'LAST_MOD' => '2013-09-27T10:57:08+02:00',
				'C' => 'NO',
				'NODES' => '0800001908000013,0800001908000022,0800001908000031,0800001908000040,0800001908000068,0800001908000077,
				0800001908000086,0800001908600017,0800001908600026,0800001908600035,0800001908600044,0800001908600053,0800001908600062',
				'DISABLED' => null
			)
		);
		$this->orgResultArray = array(
			'0800000033' => 'Fish Producer',
			'0800001403' => 'Heinz',
			'0800002819' => 'Tracetracker'
		);
		$this->orgResultArrayNamesFirst = array(
			'Fish Producer' => '0800000033',
			'Heinz' => '0800001403',
			'Tracetracker' => '0800002819'
		);
		$this->nodeResultArray = array(
			'0800002819000013' => 'Asset Demo',
			'0800001908000077' => "Developer's local TIX (used by epcistest)",
			'0800001908000086' => "Developer's local TIX (1)"
		);
		$this->nodeResultArrayNamesFirst = array(
			'Asset Demo' => '0800002819000013',
			"Developer's local TIX (used by epcistest)" => '0800001908000077',
			"Developer's local TIX (1)" => '0800001908000086'
		);
		$this->gnsParentNodesResult = new stdClass();
		$this->gnsParentNodesResult->error = null;
		$this->gnsParentNodesResult->result = array(
			array(
				"id" => "urn:tracetracker:gns:DEMO:0800001908000013",
				"FN" => "Asset Demo",
				"MESSAGES" => 0,
				"HUB" => "1000000018900023",
				"AT" => "HESSIAN_HTTPS",
				"NA" => "https://demo.tracetracker.com:9843/tix/asset",
				"ENV" => "DEMO",
				"TIXID" => "DEMO",
				"NID" => "0800002819000013",
				"NN" => "asset",
				"DUNS" => null,
				"GLN" => null,
				"AA" => "https://demo-tix.tracetracker.com/tix/asset",
				"LAST_MOD" => "2012-03-25 15:48:45"
			),
			array(
				"id" => "urn:tracetracker:gns:DEVELOPMENT:0800001908000077",
				"AA" => "https://localhost:8643/tix/epcistest",
				"LAST_MOD" => "2012-08-10 09:40:00",
				"ENV" => "DEVELOPMENT",
				"NN" => "epcistest",
				"NA" => "https://localhost:9643/tix/epcistest",
				"HUB" => "0990000013000013",
				"GLN" => null,
				"AT" => "HESSIAN_HTTPS",
				"DUNS" => null,
				"MESSAGES" => 0,
				"FN" => "Developer's local TIX (used by epcistest)",
				"NID" => "0800001908000077",
				"TIXID" => "DEVELOPMENT"
			),
			array(
				"id" => "urn:tracetracker:gns:DEVELOPMENT:0800001908000086",
				"TIXID" => "DEVELOPMENT",
				"NA" => "https://localhost:9643/tix/trunk",
				"MESSAGES" => 0,
				"GLN" => null,
				"AA" => "https://localhost:8643/tix/trunk",
				"AT" => "HESSIAN_HTTPS",
				"ENV" => "DEVELOPMENT",
				"DUNS" => null, 
				"LAST_MOD" => "2012-08-10 09:40:00",
				"NID" => "0800001908000086",
				"HUB" => "0990000013000013",
				"FN" => "Developer's local TIX (1)",
				"NN" => "trunk"
			)
		);
		$this->manageNodeResult = array(
			'error' => null,
			'org' => array(
				array(
					'orgName' => 'Fish Producer',
					'orgId' => '0800000033',
					'gln' => '0751514000009',
					'masterDataService' => '',
					'masterDataVocabulary' => '',
					'masterDataElement' => '',
					'type' => 'DSBOWNER'
					),
				array(
					'orgName' => 'Heinz',
					'orgId' => '0800001403',
					'gln' => '',
					'masterDataService' => '',
					'masterDataVocabulary' => '',
					'masterDataElement' => '',
					'type' => 'GTNET'
					),
				array(
					'orgName' => 'Tracetracker',
					'orgId' => '0800002819',
					'gln' => '',
					'masterDataService' => '',
					'masterDataVocabulary' => '',
					'masterDataElement' => '',
					'type' => 'GTNET'
				),
				array(
					'orgName' => "Frode's fish and mermaids",
					'orgId' => '0800002819',
					'gln' => '',
					'masterDataService' => '',
					'masterDataVocabulary' => '',
					'masterDataElement' => '',
					'type' => 'GTNET'
				)
			),
			'node' => array(
				array(
						'manageOrgName' => 'TraceTracker',
						'manageOrgId' => '0800002819',
						'manageNode' => 'Asset Demo',
						'manageNodeId' => '0800002819000013',
						'env' => 'DEMO',
						'tixId' => 'DEMO',
						'deleteButton' => "<button title='Disable' id='nodeStatus-0800002819000013' onclick=\"$('#sendBox').dialog('open');disableConfirmwidget235('0800002819000013', '0800002819000013-Disable', 'Disable', 'DEMO')\" ><img src=/usr/bin/images/arrowsgreen.png /></button>",
						'disabled' => null
					)

				)
		);
	
		$this->defaultResult = new stdClass();
		$this->defaultResult->result = null;
		$this->defaultResult->error = self::ERROR_MESSAGE;
		$this->defaultResult->errorCode = self::ERRORCODE;

		$this->ldapGroupSearchResult = array(
			'count' => 17,
			array(
				'cn' => array(
							'count' => 1,
							'0' => 'ROLE_ADMIN'
						),
				'0' => 'cn',
				'description' => array(
						'count' => 1,
						'0' => 'Grants access to all user levels of an application'
					),
				'1' => 'description',
				'businesscategory' => array(
						'count' => 1,
						'0' => 'ALL'
					),
				'2' => 'businesscategory',
				'count' => 3,
				'dn' => 'cn=ROLE_ADMIN,ou=Groups,dc=tracetracker,dc=com'
			),
			array(
				'cn' => array(
						'count' => 1,
						'0' => 'ROLE_DATA_IMPORTER'
					),
				'0' => 'cn',
				'description' => array(
						'count' => 1,
						'0' => 'Grants access to TIX capture/import'
					),
				'1' => 'description',
				'businesscategory' => array(
						'count' => 1,
						'0' => 'ALL'
					),
				'2' => 'businesscategory',
				'count' => 3,
				'dn' => 'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com'
			),
			array(
				'cn' => array(
						'count' => 1,
						'0' => 'ROLE_MANAGER'
					),
				'0' => 'cn',
				'businesscategory' => array(
						'count' => 1,
						'0' => 'TT'
					),
				'1' => 'businesscategory',
				'count' => 2,
				'dn' => 'cn=ROLE_MANAGER,ou=Groups,dc=tracetracker,dc=com'
			)
		);

		$this->ldapUserSearchResult = array(
			'count' => 7,
			0 => array(
				'o' => array(
						'count' => 1,
						0 => '0800002819'
					),
				0 => 'o',
				'mail' => array(
						'count' => 1,
						0 => 'ops+proffpartner_api@tracetracker.com'
					),
				1 => 'mail',
				'uid' => array(
						'count' => 1,
						0 => 'proffpartner_api'
					),
				2 => 'uid',
				'memberof' => array(
						'count' => 4,
						0 => 'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com',
						1 => 'cn=ROLE_WORKER,ou=Groups,dc=tracetracker,dc=com',
						2 => 'cn=ROLE_API,ou=Groups,dc=tracetracker,dc=com',
						3 => 'cn=ROLE_CONSOLE,ou=Groups,dc=tracetracker,dc=com'
					),
				3 => 'memberof',
				'ou' => array(
						'count' => 1,
						0 => 'People'
					),
				4 => 'ou',
				'givenname' => array(
						'count' => 1,
						0 => 'proff'
					),
				5 => 'givenname',
				'count' => 6,
				'dn' => 'uid=proffpartner_api,ou=People,dc=tracetracker,dc=com',
			),
			1 => array(
				'uid' => array(
						'count' => 1,
						0 => 'testg',
					),
				0 => 'uid',
				'ou' => array(
						'count' => 1,
						0 => 'People'
					),
				1 => 'ou',
				'o' => array(
						'count' => 1,
						0 => '1000000033'
					),
				2 => 'o',
				'mail' => array(
						'count' => 1,
						0 => 'chirag+testG@tracetracker.com'
					),
				3 => 'mail',
				'memberof' => array(
						'count' => 12,
						0 => 'cn=ROLE_ADMIN,ou=Groups,dc=tracetracker,dc=com',
						1 => 'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com',
						2 => 'cn=ROLE_MANAGER,ou=Groups,dc=tracetracker,dc=com',
						3 => 'cn=ROLE_GNSAdmin,ou=Groups,dc=tracetracker,dc=com',
						4 => 'cn=ROLE_GNSCapture,ou=Groups,dc=tracetracker,dc=com',
						5 => 'cn=ROLE_GNSQuery,ou=Groups,dc=tracetracker,dc=com',
						6 => 'cn=ROLE_WORKER,ou=Groups,dc=tracetracker,dc=com',
						7 => 'cn=ROLE_TTADMIN,ou=Groups,dc=tracetracker,dc=com',
						8 => 'cn=ROLE_API,ou=Groups,dc=tracetracker,dc=com',
						9 => 'cn=ROLE_TT,ou=Groups,dc=tracetracker,dc=com',
						10 => 'cn=ROLE_SUPERADMIN,ou=Groups,dc=tracetracker,dc=com',
						11 => 'cn=ROLE_CONSOLE,ou=Groups,dc=tracetracker,dc=com'
					),
				4 => 'memberof',
				'givenname' => array(
						'count' => 1,
						0 => 'testg'
					),
				5 => 'givenname',
				'count' => 6,
				'dn' => 'uid=testg,ou=People,dc=tracetracker,dc=com'
			)
		);

		$this->getOrgUsersResult = array(
			0 => array(
					'organizationId' => '0800002819',
					'userEmail' => 'ops+proffpartner_api@tracetracker.com',
					'organizationName' => 'Tracetracker',
					'organizationType' => 'GTNET',
					'givenName' => 'proff',
					'userName' => 'proffpartner_api',
					'memberOf' => array(
							'count' => 4,
							0 => 'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com',
							1 => 'cn=ROLE_WORKER,ou=Groups,dc=tracetracker,dc=com',
							2 => 'cn=ROLE_API,ou=Groups,dc=tracetracker,dc=com',
							3 => 'cn=ROLE_CONSOLE,ou=Groups,dc=tracetracker,dc=com'
						),

					'dn' => 'uid=proffpartner_api,ou=People,dc=tracetracker,dc=com'
				),
			1 => array(
					'organizationId' => '1000000033',
					'userEmail' => 'chirag+testG@tracetracker.com',
					//'organizationName' => 'Unknown',
					'organizationName' => '[1000000033]',
					'organizationType' => 'GTNET',
					'givenName' => 'testg',
					'userName' => 'testg',
					'memberOf' => array(
							'count' => 12,
							0 => 'cn=ROLE_ADMIN,ou=Groups,dc=tracetracker,dc=com',
							1 => 'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com',
							2 => 'cn=ROLE_MANAGER,ou=Groups,dc=tracetracker,dc=com',
							3 => 'cn=ROLE_GNSAdmin,ou=Groups,dc=tracetracker,dc=com',
							4 => 'cn=ROLE_GNSCapture,ou=Groups,dc=tracetracker,dc=com',
							5 => 'cn=ROLE_GNSQuery,ou=Groups,dc=tracetracker,dc=com',
							6 => 'cn=ROLE_WORKER,ou=Groups,dc=tracetracker,dc=com',
							7 => 'cn=ROLE_TTADMIN,ou=Groups,dc=tracetracker,dc=com',
							8 => 'cn=ROLE_API,ou=Groups,dc=tracetracker,dc=com',
							9 => 'cn=ROLE_TT,ou=Groups,dc=tracetracker,dc=com',
							10 => 'cn=ROLE_SUPERADMIN,ou=Groups,dc=tracetracker,dc=com',
							11 => 'cn=ROLE_CONSOLE,ou=Groups,dc=tracetracker,dc=com'
						),

					'dn' => 'uid=testg,ou=People,dc=tracetracker,dc=com'
				)

		);
		
		$this->getLdapRoleListResult = array(
			'cn=ROLE_ADMIN,ou=Groups,dc=tracetracker,dc=com' => 'ROLE_ADMIN',
			'cn=ROLE_DATA_IMPORTER,ou=Groups,dc=tracetracker,dc=com' => 'ROLE_DATA_IMPORTER',
			'cn=ROLE_MANAGER,ou=Groups,dc=tracetracker,dc=com' => 'ROLE_MANAGER'
		);
		$this->productListResult = new stdClass();
		$this->productListResult->error = null;
		$this->productListResult->result = array(
			0 => array(
				'id' => 'urn:epc:idpat:sgtin:7074802.235062.*',
				'urn:esporing:obj:mda:someint' => '452',
				'urn:esporing:obj:mda:somestr' => 'Fraughting',
				'urn:esporing:obj:mda:description' => "Kohlrabi's Revolver's",
				'urn:esporing:obj:mda:produrl' => 'www.implosion.no',
				'urn:esporing:obj:mda:somereal' => '99.3806443031751'
			),
			1 => array(
				'id' => 'urn:epc:idpat:sgtin:7074951.617306.*',
				'urn:esporing:obj:mda:someint' => '369',
				'urn:esporing:obj:mda:produrl' => 'www.racists.no',
				'urn:esporing:obj:mda:somestr' => "Maryland's",
				'urn:esporing:obj:mda:description' => "Midriff's Anglican",
				'urn:esporing:obj:mda:somereal' => '6.30060861093575'
			),
			2 => array(
				'id' => 'urn:epc:idpat:sgtin:7075089.441771.*',
				'urn:esporing:obj:mda:somestr' => "Rosemary's",
				'urn:esporing:obj:mda:produrl' => 'www.smudgy.no',
				'urn:esporing:obj:mda:description' => 'Hydroelectric Internee',
				'urn:esporing:obj:mda:someint' => '656',
				'urn:esporing:obj:mda:somereal' => '45.427724771281',
			)
		);
		
		$this->productListResultArray = array(
			'urn:epc:idpat:sgtin:7074802.235062.*' => "Kohlrabi's Revolver's",
			'urn:epc:idpat:sgtin:7074951.617306.*' => "Midriff's Anglican",
			'urn:epc:idpat:sgtin:7075089.441771.*' => "Hydroelectric Internee"
		);
		$this->orgMappingsResult = new stdClass();
		$this->orgMappingsResult->result = array(
			array(
					'id' => 'AEPC Collector',
					'org-id' => '0800002873'
				),
			array(
					'id' => 'Shamba',
					'org-id' => '0800002819'
				),
			array(
					'id' => 'Alias',
					'gan-id' => '0800002819000013'
				),
			array(
					'id' => 'Feed Company',
					'gln' => '3012846200107'
				),
			array(
					'id' => 'Fish Producer',
					'org-id' => '0800000033'
				),
		);

	}
	/**
	 * configureStub 
	 * @param  mixed $returnValue What should returned from the TIX query
	 * @return void
	 */
	private function configureStub() {

		$this->mds = $this->getMock( 'TMdsResource' );
		$this->ldap = $this->getMock( 'TLdapResource' );
		$this->tix = $this->getMock( 'TTixResource' );
	}
	
	/**
	 * getDashboardResourceCallback callback for getDashboardParams tests
	 * @return object
	 */
	public function getDashboardResourceCallback() {
		$args = func_get_args();
		$firstMdsQueryParams = array(null, 'mds', 'noCache');
		$secondMdsQueryParams = array(null, 'mds', 'cache');
		//$firstMdsQueryParams = array(null, 'mds', 'extended', 'elementList', 'noCache');
		//$secondMdsQueryParams = array(null, 'mds', 'simple', 'elementList', 'cache');
		$this->callCount++;
		// echo $this->level; die();
		//if($firstMdsQueryParams == array_intersect_assoc($args, $firstMdsQueryParams)) {
		if($this->callCount == 1 && $firstMdsQueryParams == array_intersect_assoc($args, $firstMdsQueryParams) && $this->level <= 4) {
			return $this->userElementResult;
		}
		//if($secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams)) {
		if($this->callCount == 2 && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level <= 3) {
			return $this->instanceElementResult;
		}
		// The parameters used for the 2nd and 3rd call to mdsQuery are the same
		if($this->callCount == 3 && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level == 2) {
		// var_dump($args); die('123');
			return $this->orgElementResult;
		}
		// The parameters used for the 2nd, 3rd & 4th call to mdsQuery are the same
		if($this->callCount = 4 && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && false == $this->triggerError
			&& $this->fetchGeoloc == true) {
			return $this->extensionQueryResult;
		}
		return $this->defaultResult;

	}
	/**
	 * testGetDashboardParameters 
	 * @return void
	 */
	public function testGetDashboardParameters() {
		$this->configureStub();
		$this->fetchGeoloc = false;
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID);
		$this->assertEquals($this->testGetDashboardParamsResult, $result);
		
	}
	/**
	 * testGetDashboardParametersUserLevelError 
	 * @return void
	 */
	public function testGetDashboardParametersUserLevelError() {
		$this->level = 5;
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID);
		// $this->assertEquals($this->testGetDashboardParamsResult, $result);
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetDashboardParametersInstanceLevelError 
	 * @return void
	 */
	public function testGetDashboardParametersInstanceLevelError() {
		$this->level = 4;
		$this->configureStub();
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID);
		// print_r($result); die();
		$this->assertNotContains($this->instanceElementResult, $result);
	}
	/**
	 * testGetDashboardParametersOrgLevelError
	 * @return void
	 */
	public function testGetDashboardParametersOrgLevelError() {
		$this->level = 3;
		$this->configureStub();
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID);
		// print_r($result); die();
		$this->assertNotContains($this->orgElementResult, $result);
	}
	/**
	 * testGetDashboardParametersWithExtension
	 * @return void
	 */
	public function testGetDashboardParametersWithExtension() {
		$this->configureStub();
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID, array());
		// print_r($result); die();
		$this->assertNotEmpty($result["type"]);
	}
	/**
	 * testGetDashboardParametersWithExtensionError
	 * @return void
	 */
	public function testGetDashboardParametersWithExtensionError() {
		$this->triggerError = true;
		$this->configureStub();
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters(self::WIDGETID, array(), array(self::EXTENSION_NAME));
		// print_r($result); die();
		$this->assertEmpty($result[self::EXTENSION_NAME]);
	}
	/**
	 * testGetDashboardParametersWithStaticDates
	 * @return void
	 */
	public function testGetDashboardParametersWithStaticDates() {
		$this->configureStub();
		$this->fetchGeoloc = false;
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getDashboardResourceCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getDashboardParameters('widget236');
		
		$this->testGetDashboardParamsResult['dateFrom'] = new DateTime('13-03-2013');
		$this->testGetDashboardParamsResult['dateTo'] = new DateTime('13-09-2013');
		$this->testGetDashboardParamsResult['dateTo']->add(new DateInterval('PT23H59M59S'));
		$this->testGetDashboardParamsResult['rangeType'] = 'static';
		// print_r($result); die('rrrr');
		$this->assertEquals($this->testGetDashboardParamsResult, $result);
	}
	/**
	 * testGetLocationAsList
	 * @return void
	 */
	public function testGetLocationAsList() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->locationResult ));
		$this->dashboard->setMdsResource($this->mds);

		$result = $this->dashboard->getLocation(Yii::app()->params->constants['locationNameVocabulary'], Yii::app()->params->constants['locationNameAttribute'], '', true );
		// print_r($result); die();
		$this->assertEquals($this->locationArray, $result);

	}
	/**
	 * testGetLocationListWithError 
	 * @return void
	 */
	public function testGetLocationListWithError() {
		$this->configureStub();
		$this->locationResult->result = null;
		$this->locationResult->error = self::ERROR_MESSAGE;
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->locationResult ));
		$this->dashboard->setMdsResource($this->mds);

		$result = $this->dashboard->getLocation(Yii::app()->params->constants['locationNameVocabulary'], Yii::app()->params->constants['locationNameAttribute'], '', true );
		// $result = $this->dashboard->getLocation(Yii::app()->params->constants['locationNameVocabulary'],Yii::app()->params->constants['locationNameAttribute'], 'urn:gtnet:idpat:gsli:1.1353.*' );
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetLocationSingleLocation
	 * @return void
	 */
	public function testGetLocationSingleLocation() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->singleLocation ));
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getLocation(Yii::app()->params->constants['locationNameVocabulary'], Yii::app()->params->constants['locationNameAttribute'], 'urn:gtnet:idpat:gsli:1.1353.*' );
		// print_r($result); die();
		$this->assertEquals(array('urn%3Agtnet%3Aidpat%3Agsli%3A1.1353.%2A' => 'urn%3Agtnet%3Aidpat%3Agsli%3A1.1353.%2A'), $result);

	}
	/**
	 * manageNodeCallback
	 * @return void
	 */
	public function manageNodeCallback() {
		$args = func_get_args();
		// $firstGnsQueryParams = array(null, 'gns', 'simple', 'elementList', 'cache');
		// $secondMdsQueryParams = array(null, 'gns', 'extended', 'elementList', 'cache');
		$this->callCount++;
		// echo $this->level; die();
		if($this->callCount  == 1) {
		// if($this->callCount == 1 && $firstMdsQueryParams == array_intersect_assoc($args, $firstMdsQueryParams) && $this->level <= 4) {
			return $this->getOrgResult;
		}
		// //if($secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams)) {
		if($this->callCount  == 2 && !Yii::app()->rbac->checkRules("showGTNET")) { // && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level <= 3) {
			return $this->gnsParentResult;
			
		}
		if($this->callCount  == 2 && Yii::app()->rbac->checkRules("showGTNET")) { // && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level <= 3) {
			return $this->gnsParentNodesResult;
		}
		if($this->callCount  == 3) { // && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level <= 3) {
			return $this->orgResult;
			
		}
		if($this->callCount  == 4) { // && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level <= 3) {
			return $this->gnsParentNodesResult;
			
		}
		// // The parameters used for the 2nd and 3rd call to mdsQuery are the same
		// if($this->callCount == 3 && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && $this->level == 2) {
		// // var_dump($args); die('123');
		// 	return $this->orgElementResult;
		// }
		// // The parameters used for the 2nd, 3rd & 4th call to mdsQuery are the same
		// if($this->callCount = 4 && $secondMdsQueryParams == array_intersect_assoc($args, $secondMdsQueryParams) && false == $this->triggerError) {
		// 	return $this->extensionQueryResult;
		// }
		$defaultResult = new stdClass();
		$defaultResult->result = null;
		$defaultResult->error = 'Error Test';
		return $defaultResult;
	}
	/**
	 * testManageNode
	 * @return void
	 */
	public function testManageNode() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(4) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'manageNodeCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->manageNode(self::WIDGETID);
		// print_r($result); die();
		$this->assertEquals($this->manageNodeResult, $result);

	}
	/**
	 * testManageNodeAsTTADMIN 
	 * @return void
	 */
	public function testManageNodeAsTTADMIN() {
		$this->configureStub();
		// modify usergroups in session
		$userGroups = Yii::app()->session['userGroups'];
		array_push($userGroups, "ROLE_TTADMIN");
		Yii::app()->session->add('userGroups', $userGroups);
		// print_r(Yii::app()->session['userGroups']); die();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'manageNodeCallback') ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->manageNode(self::WIDGETID);
		unset($this->manageNodeResult['org'][3]);
		// print_r($this->manageNodeResult); die();
		$this->assertEquals($this->manageNodeResult, $result);
	}
	/**
	 * testManageNodeWithErrors
	 * @return void
	 */
	public function testManageNodeWithErrors() {
		$this->configureStub();
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->manageNode(self::WIDGETID);
		// print_r($result); die();
		$this->assertEmpty($result['org']);
		$this->assertEmpty($result['node']);
		$this->assertNotNull($result['error']);

	}
	/**
	 * testManageNodeOrgWithErrorAsTTADMIN 
	 * @return void
	 */
	public function testManageNodeOrgWithErrorAsTTADMIN() {
		$this->configureStub();
		// modify usergroups in session
		$userGroups = Yii::app()->session['userGroups'];
		array_push($userGroups, "ROLE_TTADMIN");
		Yii::app()->session->add('userGroups', $userGroups);
		$this->mds->expects( $this->any() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->manageNode(self::WIDGETID);
		// print_r($result); die();
		$this->assertEmpty($result['org']);
		$this->assertEmpty($result['node']);
	}
	/**
	 * testGetLdapRoleList 
	 * @return void
	 */
	public function testGetLdapRoleList() {
		$this->configureStub();
		$this->ldap->expects( $this->exactly(1) )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->exactly(1) )
			->method( 'ldapSearch' )
			->will( $this->returnValue( $this->ldapGroupSearchResult ) );
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getLdapRoleList(array("ALL"));
		$this->assertEquals($this->getLdapRoleListResult, $result);

	}
	/**
	 * testGetLdapRoleListConnectError 
	 * @return void
	 */
	public function testGetLdapRoleListConnectError() {
		$this->configureStub();
		$this->ldap->expects( $this->exactly(1) )
			->method( 'ldapConnect' )
			->will( $this->returnValue( false ) );
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getLdapRoleList(array("ALL"));
		$this->assertEmpty($result);

	}
	/**
	 * testGetLdapRoleListSearchError 
	 * @return void
	 */
	public function testGetLdapRoleListSearchError() {
		$this->configureStub();
		$this->ldap->expects( $this->exactly(1) )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->exactly(1) )
			->method( 'ldapSearch' )
			->will( $this->returnValue( false ) );
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getLdapRoleList(array("ALL"));
		$this->assertEmpty($result);
	}
	/**
	 * testGetOrg 
	 * @return void
	 */
	public function testGetOrg() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('organization');
		// print_r($result); die();
		$this->assertEquals($this->orgResultArray, $result);

	}
	/**
	 * testGetOrgNodes
	 * @return void
	 */
	public function testGetOrgNodes() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('node');
		// print_r($result); die();
		$this->assertEquals($this->nodeResultArray, $result);
	}
	/**
	 * testGetOrgNamesFirst 
	 * @return void
	 */
	public function testGetOrgNamesFirst() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('organization', 1);
		// print_r($result); die();
		$this->assertEquals($this->orgResultArrayNamesFirst, $result);
	}
	/**
	 * testGetOrgNodeNamesFirst
	 * @return void
	 */
	public function testGetOrgNodeNamesFirst() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('node', 1);
		// print_r($result); die();
		$this->assertEquals($this->nodeResultArrayNamesFirst, $result);
	}
	/**
	 * testGetOrgWithDsbCheck
	 * @return void
	 */
	public function testGetOrgWithDsbCheck() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('organization', '', 1);
		// print_r($result); die();
		$dsbCheckResult = array(
			'orgType' => 'DSBOWNER',
			'parent' => '0800000033'
		);
		$this->assertEquals($dsbCheckResult, $result);

	}
	/**
	 * testGetOrgWithDsbCheckGtnet 
	 * @return void
	 */
	public function testGetOrgWithDsbCheckGtnet() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->getOrgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('organization', '', 1);
		// print_r($result); die();
		$dsbCheckResult = array(
			'orgType' => 'normal'
		);
		$this->assertEquals($dsbCheckResult, $result);
	}
	/**
	 * testGetOrgWithMultipleOrgs
	 * @return void
	 */
	public function testGetOrgWithMultipleOrgs() {
		
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$orgIds = array('0800000033', '0800001403', '0800002819');
		$result = $this->dashboard->getOrg('organization', '', '', $orgIds);
		// print_r($result); die();
		$this->assertEquals($this->orgResultArray, $result);
	}
	/**
	 * testGetOrgWithMultipleOrgsNamesFirst
	 * @return void
	 */
	public function testGetOrgWithMultipleOrgsNamesFirst() {
		
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		// $this->orgIds = array('0800000033', '0800001403', '0800002819');
		$result = $this->dashboard->getOrg('organization', 1, '', $this->orgIds);
		// print_r($result); die();
		$this->assertEquals($this->orgResultArrayNamesFirst, $result);
	}

	/**
	 * testGetOrgNodesWithDsbCheck
	 * @return void
	 */
	public function testGetOrgNodesWithDsbCheck() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getOrg('node', '', 1);
		// print_r($result); die();
		$this->assertEmpty($result);

	}
	/**
	 * testGetOrgNodesWithMultipleOrgs
	 * @return void
	 */
	public function testGetOrgNodesWithMultipleOrgs() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		// $orgIds = array('0800000033', '0800001403', '0800002819');
		$result = $this->dashboard->getOrg('node', '', '', $this->orgIds);
		// print_r($result); die();
		$this->assertEquals($this->nodeResultArray, $result);
	}
	/**
	 * testGetOrgNodesWithMultipleOrgsNamesFirst 
	 * @return void
	 */
	public function testGetOrgNodesWithMultipleOrgsNamesFirst() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		// $orgIds = array('0800000033', '0800001403', '0800002819');
		$result = $this->dashboard->getOrg('node', 1, '', $this->orgIds);
		// print_r($result); die();
		$this->assertEquals($this->nodeResultArrayNamesFirst, $result);
	}
	/**
	 * testGetOrgUsers 
	 * @return void
	 */
	public function testGetOrgUsers() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', Yii::app()->params->ldap['ou']);
		//print_r($result); die();
		$this->assertEquals($this->getOrgUsersResult, $result);
	}
	/**
	 * testGetOrgUsersWithOrgList
	 * @return void
	 */
	public function testGetOrgUsersWithOrgList() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers($this->orgIdString, Yii::app()->params->ldap['ou']);
		// print_r($result); die("kjkj");
		$this->assertEquals($this->getOrgUsersResult, $result);
	}
	public function testGetOrgUsersWithMDSError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers($this->orgIdString, Yii::app()->params->ldap['ou']);
		// print_r($result); die("kjkj");
		$this->assertStringMatchesFormat("Network Error. Could not load the Organizations. Reload the widget.", $result);
	}
	/**
	 * testGetOrgUsersDefaultOuParam
	 * @return void
	 */
	public function testGetOrgUsersDefaultOuParam() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', 'current');
		// print_r($result); die("kjkj");
		$this->assertEquals($this->getOrgUsersResult, $result);
	}
	/**
	 * testGetOrgUsersWithLdapConnectError
	 * @return void
	 */
	public function testGetOrgUsersWithLdapConnectError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( "Error" ) );
		$this->ldap->expects( $this->never() )
			->method( 'ldapSearch' );
			//->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->never() )
			->method( 'elementListMdsQuery' );
			//->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', Yii::app()->params->ldap['ou']);
		// print_r($result); die("kjkj");
		$this->assertEmpty($result);
	}
	/**
	 * testGetOrgUsersWithLdapSearchError 
	 * @return void
	 */
	public function testGetOrgUsersWithLdapSearchError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( "Error" ) );
		$this->mds->expects( $this->never() )
			->method( 'elementListMdsQuery' );
			//->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', Yii::app()->params->ldap['ou']);
		// print_r($result); die("kjkj");
		$this->assertEmpty($result);
	}
	/**
	 * testGetOrgUsersWithLdapConnectErrorAndDefaultOuParam 
	 * @return void
	 */
	public function testGetOrgUsersWithLdapConnectErrorAndDefaultOuParam() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( "Error" ) );
		$this->ldap->expects( $this->never() )
			->method( 'ldapSearch' );
			//->will( $this->returnValue( $this->ldapUserSearchResult ) );
		$this->mds->expects( $this->never() )
			->method( 'elementListMdsQuery' );
			//->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', 'current');
		// print_r($result); die("kjkj");
		$this->assertEmpty($result);
	}
	/**
	 * testGetOrgUsersWithLdapSearchAndDefaultOuParam
	 * @return [type] [description]
	 */
	public function testGetOrgUsersWithLdapSearchAndDefaultOuParam() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapSearch' )
			->will( $this->returnValue( "Error" ) );
		$this->mds->expects( $this->never() )
			->method( 'elementListMdsQuery' );
			//->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->getOrgUsers('0800002819', 'current');
		// print_r($result); die("kjkj");
		$this->assertEmpty($result);
	}
	/**
	 * testGetProductName
	 * @return void
	 */
	public function testGetProductName() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->productListResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getProductName(Yii::app()->params->constants['productNameVocabulary'], Yii::app()->params->constants['productNameAttribute'], '');
		// print_r($result); die();
		$this->assertEquals($this->productListResultArray, $result);
	}
	/**
	 * testGetProductNameWithError
	 * @return void
	 */
	public function testGetProductNameWithError() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getProductName(Yii::app()->params->constants['productNameVocabulary'], Yii::app()->params->constants['productNameAttribute'], '');
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetProductNameEmptyResult
	 * @return void
	 */
	public function testGetProductNameEmptyResult() {
		$this->configureStub();
		// make the result empty
		$this->productListResult->result = null;
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->productListResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getProductName(Yii::app()->params->constants['productNameVocabulary'], Yii::app()->params->constants['productNameAttribute'], '');
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetProductNameSingle
	 * @return void
	 */
	public function testGetProductNameSingle() {
		$this->configureStub();
		// ensure there is only one result
		unset($this->productListResult->result[1]);
		unset($this->productListResult->result[2]);
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->productListResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getProductName(Yii::app()->params->constants['productNameVocabulary'], Yii::app()->params->constants['productNameAttribute'], $this->productListResult->result[0]['id'], false);
		// print_r($result); die();
		$this->assertEquals(array('0' => "Kohlrabi's Revolver's"), $result);
	}
	/**
	 * testGetNodeDetails
	 * @return void
	 */
	public function testGetNodeDetails() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getNodeDetails('0800002819000013');
		// print_r($result); die();
		$this->assertArrayHasKey('nodeDetails', $result);
		$this->assertNotEmpty($result['nodeDetails']);
	}
	/**
	 * testGetNodeDetailsWithEnv
	 * @return void
	 */
	public function testGetNodeDetailsWithEnv() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->gnsParentNodesResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getNodeDetails('0800002819000013', Yii::app()->params->gns['environment']);
		// print_r($result); die();
		$this->assertArrayHasKey('nodeDetails', $result);
		$this->assertNotEmpty($result['nodeDetails']);
	}
	/**
	 * [testGetNodeDetailsWithError
	 * @return void
	 */
	public function testGetNodeDetailsWithError() {
		$this->configureStub();
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getNodeDetails('0800002819000013');
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetNodeDetailsEmptyResult 
	 * @return void
	 */
	public function testGetNodeDetailsEmptyResult() {
		$this->configureStub();
		//make error property empty
		$this->defaultResult->error = null;
		$this->mds->expects( $this->once() )
			->method( 'elementListMdsQuery' )
			->will( $this->returnValue( $this->defaultResult ) );
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getNodeDetails('0800002819000013');
		// print_r($result); die();
		$this->assertEmpty($result);
	}
	/**
	 * testGetSenderReceiverNamesWithOrgId
	 * @return void
	 */
	public function testGetSenderReceiverNamesWithOrgId() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		$this->dashboard->setMdsResource($this->mds);
		//$this->dashboard->setTixResource($this->tix);
		$result = $this->dashboard->getSenderReceiverNames('0800000033', 'org-id');
		// print_r($result); die();
		$this->assertEquals("Fish Producer", $result);
	}
	/**
	 * testGetSenderReceiverNamesWithNodeId
	 * @return void
	 */
	public function testGetSenderReceiverNamesWithNodeId() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		$this->dashboard->setMdsResource($this->mds);
		// $this->dashboard->setTixResource($this->tix);
		$result = $this->dashboard->getSenderReceiverNames('0800002819000013', 'gan-id');
		// print_r($result); die();
		$this->assertEquals("Tracetracker Asset Demo", $result);
	}
	/**
	 * testGetSenderReceiverNamesWithOrgMapping
	 * @return void
	 */
	public function testGetSenderReceiverNamesWithGanIdOrgMapping() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		$this->dashboard->setMdsResource($this->mds);
		// $this->dashboard->setTixResource($this->tix);
		$result = $this->dashboard->getSenderReceiverNames('Alias', 'org-mapping');
		// print_r($result); die();
		$this->assertEquals("Tracetracker Asset Demo", $result);
	}
	/**
	 * testGetSenderReceiverNamesWithOrgIdOrgMapping
	 * @return void
	 */
	public function testGetSenderReceiverNamesWithOrgIdOrgMapping() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		// $this->dashboard->setTixResource($this->tix);
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getSenderReceiverNames('Shamba', 'org-mapping');
		// print_r($result); die();
		$this->assertEquals("Tracetracker", $result);
	}

	public function testGetSenderReceiverNamesOrgIdWithError() {
		$this->configureStub();
		$this->triggerError = true;
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		// $this->dashboard->setTixResource($this->tix);
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getSenderReceiverNames('0800000033', 'org-id');
		// print_r($result); die();
		$this->assertEquals("[0800000033]", $result);
	}
	public function testGetSenderReceiverNamesNodeIdWithError() {
		$this->configureStub();
		$this->triggerError = true;
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->orgMappingsResult));
		// $this->dashboard->setTixResource($this->tix);
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getSenderReceiverNames('0123456789ABCDEF', 'gan-id');
		// print_r($result); die();
		$this->assertEquals("[0123456789ABCDEF]", $result);
	}
	public function testGetSenderReceiverNamesOrgMappingWithError() {
		$this->configureStub();
		$this->mds->expects( $this->exactly(3) )
			->method( 'elementListMdsQuery' )
			->will( $this->returnCallback( array($this, 'getOrgCallback') ) );
		// $this->tix->expects($this->once())
		// 	->method( 'orgMapping')
		// 	->will( $this->returnValue( $this->defaultResult));
		// $this->dashboard->setTixResource($this->tix);
		$this->dashboard->setMdsResource($this->mds);
		$result = $this->dashboard->getSenderReceiverNames('HAKUNA', 'gan-id');
		// print_r($result); die();
		$this->assertEquals("[HAKUNA]", $result);
	}
	/**
	 * getOrgCallback
	 * @return object
	 */
	public function getOrgCallback() {
		$this->callCount++;
		if($this->triggerError == false) {
			if($this->callCount == 1) {
				return $this->gnsParentNodesResult;
			}
			if($this->callCount == 2) {
				return $this->orgResult;
			}
			if($this->callCount == 3) {
				return $this->orgMappingsResult;
			}
		}
		return $this->defaultResult;
	}
	/**
	 * testAddUserNodes 
	 * @return void
	 */
	public function testAddUserNodes() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapBindAdmin' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapModify' )
			->will( $this->returnValue( true ) );
		$data = array();
		$data['allowGANAccess'] = array('0800005265987412', '1023650011440025');
		
			//->will( $this->returnValue( $this->orgResult ) );
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->addUserNodes($data);
		$this->assertTrue($result);

	}
	/**
	 * testAddUserNodesConnectError
	 * @return void
	 */
	public function testAddUserNodesConnectError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( "Error" ) );
		$this->ldap->expects( $this->never() )
			->method( 'ldapBindAdmin' );
		$this->ldap->expects( $this->never() )
			->method( 'ldapModify' );

		$data = array();
		$data['allowGANAccess'] = array('0800005265987412', '1023650011440025');
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->addUserNodes($data);
		$this->assertStringMatchesFormat("Unable%a", $result);

	}
	/**
	 * testAddUserBindAdminError
	 * @return void
	 */
	public function testAddUserBindAdminError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapBindAdmin' )
			->will( $this->returnValue( "Error" ) );
		$this->ldap->expects( $this->never() )
			->method( 'ldapModify' );

		$data = array();
		$data['allowGANAccess'] = array('0800005265987412', '1023650011440025');
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->addUserNodes($data);
		$this->assertStringMatchesFormat("Unable%a", $result);

	}
	/**
	 * testAddUserLdapModifyError
	 * @return void
	 */
	public function testAddUserLdapModifyError() {
		$this->configureStub();
		$this->ldap->expects( $this->once() )
			->method( 'ldapConnect' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapBindAdmin' )
			->will( $this->returnValue( true ) );
		$this->ldap->expects( $this->once() )
			->method( 'ldapModify' )
			->will( $this->returnValue( "Error" ));

		$data = array();
		$data['allowGANAccess'] = array('0800005265987412', '1023650011440025');
		$this->dashboard->setLdapResource($this->ldap);
		$result = $this->dashboard->addUserNodes($data);
		$this->assertStringMatchesFormat("Unable%a", $result);

	}




}																
