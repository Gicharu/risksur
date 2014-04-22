<?php
/**
 * TTixResourceTest
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
 * @SuppressWarnings controlCloseCurly
 * @SuppressWarnings checkWhiteSpaceBefore
 */

class TTixResourceTest extends PHPUnit_Framework_TestCase {
	const GET_INFO_RETURN_VALUE = 200;
	const GET_INFO_RETURN_ERROR_VALUE = 408;
	const REQUEST_TIMEOUT = 20000;
	const EVENT_COUNT_RESULT = 10;
	const TIMEOUT_ERROR_CODE = 28;
	const TIMEOUT_ERROR_DESRIPTION = 'Request Timeout';
	const NO_TRD = 'No Trd found';
	const GRAPH_ERROR_CODE = 1004;
	const GRAPH_ERROR_DESCRIPTION = 'Got timed out when fetching graph image, please refresh the widget';
	const ERROR_FIVE_HUNDRED = 500;
	const ERROR_FIVE_HUNDRED_DESCRIPTION = 'Server unavailable';


	private $curl;
	private $query;
	private $tixUrl;
	private $tixObject;
	private $objectResultXml;
	private $eventQueryResultXml;
	private $emptyResultXml;
	private $emptyErrorDescription;
	private $emptyErrorCode;
	private $emptyErrorCodeAttribute;
	private $emptyErrorDescriptionAttribute;
	private $tradingPartnersXml;
	private $tixNodeId;
	private $tradingPartnerFromDate;
	private $tradingPartnerToDate;
	private $tradingPartnerResult;
	private $tradingPartnersEmptyXml;
	private $trdXml;
	private $trdNodeId;
	private $trdOrgType;
	private $objectCountResult;
	private $orgMappingResultXml;
	private $orgMappingResult;
	private $orgMappingEmptyXml;
	private $aboutDetailsResult;
	private $aboutDetailsResultXml;
	private $pngString;
	private $pngResult;
	private $tixErrorString;
	private $aboutDetailsMasterDataXml;
	private $aboutDetailsMasterDataArray;
	private $tixEpcisCaptureXml;
	private $tixCapureData;
	private $graphXml;

	/**
	 * setUp
	 */
	public function setUp() {
		$this->query = 'https://test.tracetracker.com/tix/api/xml/SimpleEventQuery?MATCH_epc=urn:gtnet:id:batch:0800002873.CropType-24.ParentCrop-17_201305011369994067' . 
		'&includeProperties=true&nodeId=0800002873000013';
		$this->tixUrl = 'https://alpha.tracetracker.com/tix';
		$this->tixObject = Yii::app()->tixresource;
		$this->emptyErrorCodeAttribute = 'errorCode';
		$this->emptyErrorDescriptionAttribute = 'errorDescription';
		$this->emptyErrorCode = '1003';
		$this->emptyErrorDescription = 'No records found';
		$this->tixNodeId = '0800002873000013';
		$this->tradingPartnerToDate = '2013-09-30T23%3A59%3A59%2B0300';
		$this->tradingPartnerFromDate = '2013-07-15T00%3A00%3A00%2B0300';
		$this->trdNodeId = '0800000033000013';
		$this->trdOrgType = "DSB";
		$this->pngPath = '../processGraphPng.png?';
		Yii::app()->TradingPartnersCache->flush();
		Yii::app()->TRDCache->flush();
		Yii::app()->EnvCache->flush();

		$this->eventQueryResultXml = <<<EEQResult
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<epcisq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:ttdata="http://www.tracetracker.com/data" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader">
			<queryName>ExtendedEventQuery</queryName>
			<resultsBody>
				<EventList>
					<ObjectEvent>
						<eventTime>2013-08-24T02:00:00.000+02:00</eventTime>
						<recordTime>2013-08-30T13:39:45.766+02:00</recordTime>
						<eventTimeZoneOffset>+00:00</eventTimeZoneOffset>
						<epcList>
							<epc>urn:gtnet:id:gssi:0800002873.CropType-1.20130824113943</epc>
						</epcList>
						<action>OBSERVE</action>
						<bizStep>urn:epcglobal:cbv:bizstep:shipping</bizStep>
						<disposition>urn:epcglobal:cbv:disp:in_transit</disposition>
						<readPoint>
							<id>urn:gtnet:id:gsli:0800002873.Farm-279.Field-312</id>
						</readPoint>
						<bizLocation>
							<id>urn:gtnet:id:gsli:0800002873.Farm-279</id>
						</bizLocation>
						<gtnet-epcis:party_id xmlns="http://www.globaltraceability.net/schema/epcis">0800000033000013</gtnet-epcis:party_id>
						<gtnet-epcis:party_id_type xmlns="http://www.globaltraceability.net/schema/epcis">gan-id</gtnet-epcis:party_id_type>
					</ObjectEvent>
					<ObjectEvent>
						<eventTime>2013-08-24T02:00:00.000+02:00</eventTime>
						<recordTime>2013-08-30T13:39:45.555+02:00</recordTime>
						<eventTimeZoneOffset>+00:00</eventTimeZoneOffset>
						<epcList>
							<epc>urn:gtnet:id:gssi:0800002873.CropType-1.20130824113943</epc>
						</epcList>
						<action>ADD</action>
						<bizStep>urn:epcglobal:cbv:bizstep:commissioning</bizStep>
						<disposition>urn:epcglobal:cbv:disp:active</disposition>
						<readPoint>
							<id>urn:gtnet:id:gsli:0800002873.Farm-279.Field-312</id>
						</readPoint>
						<bizLocation>
							<id>urn:gtnet:id:gsli:0800002873.Farm-279</id>
						</bizLocation>
						<gtnet-epcis:entityClass xmlns="http://www.globaltraceability.net/schema/epcis">TradeUnit</gtnet-epcis:entityClass>
						<gtnet-epcis:trdType xmlns="http://www.globaltraceability.net/schema/epcis">outgoingshipment</gtnet-epcis:trdType>
						<ttdata:dateshipped xmlns="http://www.tracetracker.com/data">2013-08-24</ttdata:dateshipped>
						<ttdata:customername xmlns="http://www.tracetracker.com/data">urn:tracetracker:0800002873:taco:Collector:103</ttdata:customername>
						<ttdata:customernameMD xmlns="http://www.tracetracker.com/data">Helge Packer AS</ttdata:customernameMD>
						<ttdata:packingfacilitynameMD xmlns="http://www.tracetracker.com/data">HelgePackerFacility1</ttdata:packingfacilitynameMD>
						<ttdata:unloadingpoint xmlns="http://www.tracetracker.com/data">Helge‘s storage 1</ttdata:unloadingpoint>
						<ttdata:packingfacility xmlns="http://www.tracetracker.com/data">urn:tracetracker:0800002873:taco:Storage:7</ttdata:packingfacility>
						<ttdata:transportername xmlns="http://www.tracetracker.com/data">transporter 1</ttdata:transportername>
						<ttdata:truckid xmlns="http://www.tracetracker.com/data">KBB568W</ttdata:truckid>
						<ttdata:transportattachment xmlns="http://www.tracetracker.com/data"/>
						<ttdata:deliverynoteid xmlns="http://www.tracetracker.com/data"/>
						<ttdata:deliveryyear xmlns="http://www.tracetracker.com/data">2013-08-24T00:00:00+00:00</ttdata:deliveryyear>
						<ttdata:shipmentdescription xmlns="http://www.tracetracker.com/data"/>
					</ObjectEvent>
				</EventList>
			</resultsBody>
		</epcisq:QueryResults>
EEQResult;
		$this->eventQueryResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->eventQueryResultXml );
		$this->objectResultXml = <<<OBJECTRESULT
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<gqi:GQIResult xmlns:gtnet="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:gqi="http://www.tracetracker.com/gqiresult" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:ttdata="http://www.tracetracker.com/data">
			<object nodeId="0800002873000013">
				<epc>urn:gtnet:id:batch:0800002873.CropType-24.ParentCrop-17_201305011369994067</epc>
				<entityClass>Batch</entityClass>
				<label>Field</label>
				<description>Field or similar where something is grown</description>
				<created>2013-05-01T02:00:00+02:00</created>
				<quantityunitofmeasure label="Quantity Unit of Measure" updated="2013-05-01T02:00:00.000+02:00">urn:tracetracker:0800002873:taco:CropUnit:17</quantityunitofmeasure>
				<expectedharvest label="Expected Harvest Date" updated="2013-05-01T02:00:00.000+02:00">2013-05-31</expectedharvest>
				<croptype label="Crop Type" updated="2013-05-01T02:00:00.000+02:00">urn:tracetracker:0800002873:taco:CropType:24</croptype>
				<season label="[season]" updated="2013-05-01T02:00:00.000+02:00">open</season>
				<trdType label="Field" updated="2013-05-01T02:00:00.000+02:00">field</trdType>
				<seedgmo label="Seed GMO status" updated="2013-05-01T02:00:00.000+02:00">yes</seedgmo>
				<readPoint label="[readPoint]" updated="2013-05-22T02:00:00.000+02:00">urn:gtnet:id:gsli:0800002873.Farm-11.Field-31</readPoint>
				<bizLocation label="[bizLocation]" updated="2013-05-22T02:00:00.000+02:00">urn:gtnet:id:gsli:0800002873.Farm-11</bizLocation>
				<parentcroptype label="[parentcroptype]" updated="2013-05-01T02:00:00.000+02:00">urn:tracetracker:0800002873:taco:ParentCrop:17</parentcroptype>
				<plantingdate label="Planting Date" updated="2013-05-01T02:00:00.000+02:00">2013-05-01</plantingdate>
				<expectedvolume label="Expected Volume" updated="2013-05-01T02:00:00.000+02:00">50000</expectedvolume>
				<lastEventTime>2013-05-31T02:00:00+02:00</lastEventTime>
				<lastPropertyTime>2013-05-31T02:00:00+02:00</lastPropertyTime>
			</object>
		</gqi:GQIResult>
OBJECTRESULT;
		$this->objectResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->objectResultXml );
		$this->emptyResultXml = <<<EMPTYRESULT
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<gqi:GQIResult xmlns:gtnet="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" 
		xmlns:gqi="http://www.tracetracker.com/gqiresult" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" 
		xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" 
		xmlns:ttdata="http://www.tracetracker.com/data"/>
EMPTYRESULT;
		$this->emptyResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->emptyResultXml );
		$this->tradingPartnersXml = <<<TRADINGPARTNERS
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<epcisq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:ttdata="http://www.tracetracker.com/data" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader">
			<queryName>ExtendedMasterDataQuery</queryName>
			<resultsBody>
				<VocabularyList>
					<Vocabulary type="urn:tracetracker:mds:gns:organization">
						<VocabularyElementList>
							<VocabularyElement id="1">
								<attribute id="TEST">1</attribute>
								<attribute id="OID">0800000033</attribute>
								<attribute id="GLN">0751514000009</attribute>
								<attribute id="ON">no.fish</attribute>
								<attribute id="NODES">0800000033000013,0800000033000022,0800000033000031,0800000033000040,0800000033000059,0800000033000068,0800000033000077,0800000033000086</attribute>
								<attribute id="PO">0800000033</attribute>
								<attribute id="FN">Fish Producer</attribute>
								<attribute id="DUNS">080000003</attribute>
								<attribute id="LAST_MOD">2013-08-29T17:04:21+03:00</attribute>
								<attribute id="C">NO</attribute>
								<attribute id="OT">DSBOWNER</attribute>
							</VocabularyElement>
							<VocabularyElement id="2">
								<attribute id="OID">0800002873</attribute>
								<attribute id="NODES">0800002873000013,0800002873000022</attribute>
								<attribute id="ON">com.tracetracker.aepc</attribute>
								<attribute id="GLN"/>
								<attribute id="FN">AEPC</attribute>
								<attribute id="LAST_MOD">2013-08-27T14:26:34+02:00</attribute>
								<attribute id="DUNS"/>
								<attribute id="C">NO</attribute>
							</VocabularyElement>
						</VocabularyElementList>
					</Vocabulary>
				</VocabularyList>
			</resultsBody>
		</epcisq:QueryResults>
TRADINGPARTNERS;
		$this->tradingPartnersXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->tradingPartnersXml );
		$this->tradingPartnersEmptyXml = <<<EMPTYTRADINGPARTNERS
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<epcisq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:ttdata="http://www.tracetracker.com/data" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader">
			<queryName>ExtendedMasterDataQuery</queryName>
			<resultsBody>
				<VocabularyList>
					<Vocabulary type="urn:tracetracker:mds:gns:organization">
						<VocabularyElementList/>
					</Vocabulary>
				</VocabularyList>
			</resultsBody>
		</epcisq:QueryResults>
EMPTYTRADINGPARTNERS;
		$this->tradingPartnersEmptyXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->tradingPartnersEmptyXml );

		$this->tradingPartnerResult = array(
			array(
					"id" => "1",
					"TEST" => "1",
					"OID" => "0800000033",
					"GLN" => "0751514000009",
					"ON" => "no.fish",
					"NODES" => "0800000033000013,0800000033000022,0800000033000031,0800000033000040,0800000033000059,0800000033000068,0800000033000077,0800000033000086",
					"PO" => "0800000033",
					"FN" => "Fish Producer",
					"DUNS" => "080000003",
					"LAST_MOD" => "2013-08-29T17:04:21+03:00",
					"C" => "NO",
					"OT" => "DSBOWNER"
				),
			array(
					"id" => "2",
					"OID" => "0800002873",
					"NODES" => "0800002873000013,0800002873000022",
					"ON" => "com.tracetracker.aepc",
					"GLN" => "",
					"FN" => "AEPC",
					"LAST_MOD" => "2013-08-27T14:26:34+02:00",
					"DUNS" => "",
					"C" => "NO"
				)
			);
		$this->trdXml = <<<TRDXML
		<?xml version="1.0" encoding="UTF-8"?>
		<TRDef xmlns="http://www.tracetracker.com/trd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" defaultType="entity" id="default" version="1.0" 
		xsi:schemaLocation="http://www.tracetracker.com/trd http://schema.tracetracker.com/ttTRD_5_0.xsd"><Label><Text xml:lang="en">Default TRD</Text>
		<Text xml:lang="no">Standard TRD</Text></Label><Description><Text xml:lang="en">This TRD contains default definitions.</Text>
		<Text xml:lang="no">Denne TRD'en inneholder standard definisjoner.</Text></Description><PropertyTypes>
		<PropertyType format="TEXT" id="articledescription"><Label><Text xml:lang="en">Article Description</Text></Label><Description>
		<Text xml:lang="en">Supplier assigned product description including	brand</Text></Description></PropertyType><PropertyType format="TEXT" id="batchno">
		<Label><Text xml:lang="en">Batch No</Text></Label><Description><Text xml:lang="en">Supplier assigned product description including brand</Text>
		</Description></PropertyType><PropertyType format="TEXT" id="customername"><Label><Text xml:lang="en">Customer Name</Text></Label><Description>
		<Text xml:lang="en">Name of the customer</Text></Description></PropertyType><PropertyType format="TEXT" id="dateshipped"><Label>
		<Text xml:lang="en">Date Shipped</Text></Label><Description><Text xml:lang="en">date shipment was shipped</Text></Description></PropertyType>
		<PropertyType format="TEXT" id="deliveryyear"><Label><Text xml:lang="en">Delivery Year</Text></Label><Description>
		<Text xml:lang="en">year shipment is to be delivered</Text></Description></PropertyType><PropertyType format="TEXT" id="numberofitems"><Label>
		<Text xml:lang="en">Number of items</Text></Label><Description><Text xml:lang="en">numner of items</Text></Description></PropertyType>
		<PropertyType format="TEXT" id="organizationid"><Label><Text xml:lang="en">Organization ID</Text></Label><Description>
		<Text xml:lang="en">Indicates whether a GLN, a Dun and Bradstreet Number or a GTNet Identifier is being used as the organization ID.</Text>
		</Description></PropertyType><PropertyType format="TEXT" id="organizationidtype"><Label><Text xml:lang="en">Organization Id Type</Text></Label>
		<Description><Text xml:lang="en">Organization ID Type</Text></Description></PropertyType><PropertyType format="REAL" id="quantity"><Label>
		<Text xml:lang="en">Quantity</Text></Label><Description><Text xml:lang="en">Quantity</Text></Description></PropertyType>
		<PropertyType format="TEXT" id="quantityunitofmeasure"><Label><Text xml:lang="en">Quantity Unit of Measure</Text></Label><Description>
		<Text xml:lang="en">Unit the Quantity property refers to</Text></Description></PropertyType></PropertyTypes><TradeUnitTypes>
		<TradeUnitType id="entity" tradeunit-class="basic"><Label><Text xml:lang="en">Default entity</Text><Text xml:lang="no">Standard entity</Text></Label>
		<Description><Text xml:lang="en">Default TradeUnit</Text><Text xml:lang="no">Standard TradeUnit</Text></Description></TradeUnitType>
		<TradeUnitType id="finishedproduct" tradeunit-class="cluster"><Label><Text xml:lang="en">Finished Product</Text></Label><Description>
		<Text xml:lang="en">The end product of the production process prior to shipment</Text></Description>
		<PropertyRef id="articledescription" occurrence="recommended"/><PropertyRef id="batchno" occurrence="recommended"/>
		<PropertyRef id="organizationid" occurrence="recommended"/><PropertyRef id="organizationidtype" occurrence="recommended"/>
		<PropertyRef id="quantity" occurrence="recommended"/><PropertyRef id="quantityunitofmeasure" occurrence="recommended"/></TradeUnitType>
		<TradeUnitType id="incomingshipment" tradeunit-class="cluster"><Label><Text xml:lang="en">Incoming Shipment</Text></Label><Description>
		<Text xml:lang="en">incoming shipment</Text></Description></TradeUnitType><TradeUnitType id="outgoingshipment" tradeunit-class="cluster"><Label>
		<Text xml:lang="en">Outgoing Shipment</Text></Label><Description><Text xml:lang="en">The outgoing shipment of finished product</Text></Description>
		<PropertyRef id="customername" occurrence="recommended"/><PropertyRef id="dateshipped" occurrence="recommended"/>
		<PropertyRef id="deliveryyear" occurrence="recommended"/><PropertyRef id="organizationid" occurrence="recommended"/>
		<PropertyRef id="organizationidtype" occurrence="recommended"/></TradeUnitType><TradeUnitType id="receiviedproduct" tradeunit-class="cluster">
		<Label><Text xml:lang="en">Outgoing Shipment</Text></Label><Description><Text xml:lang="en">The outgoing shipment of finished product</Text>
		</Description></TradeUnitType></TradeUnitTypes></TRDef>
TRDXML;
		$this->trdXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->trdXml );
		$this->objectCountResult = "HTTP/1.1 200 OK\r\nServer: Apache-Coyote/1.1\r\nSet-Cookie: JSESSIONID=7Pyf2PW95reXoXhIdNAVomFW; Path=/tix; Secure";
		$this->objectCountResult .= "\r\nTT-Count: 17\r\nContent-Length: 0\r\nDate: Tue, 03 Sep 2013 12:55:03 GMT\r\nConnection: close\r\n\r\n";
		$this->orgMappingResultXml = <<<ORGMAPPINGRESULT
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<OrgMappings xmlns="http://www.tracetracker.com/orgMappings">
			<OrgMapping alias="testing org" orgType="org-id">1000001053</OrgMapping>
			<OrgMapping alias="66666" orgType="org-id">1000001053</OrgMapping>
			<OrgMapping alias="7777777" orgType="org-id">1000001053</OrgMapping>
			<OrgMapping alias="alias1" orgType="org-id">1000001053</OrgMapping>
			<OrgMapping alias="alias2" orgType="org-id">1000001053</OrgMapping>
		</OrgMappings>
ORGMAPPINGRESULT;
		$this->orgMappingResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->orgMappingResultXml );
		$this->orgMappingResult = array(
			0 => array(
				"alias" => 'testing org',
				"orgType" => 'org-id',
				"orgTypeVal" => '1000001053'
			),
			1 => array(
				"alias" => '66666',
				"orgType" => 'org-id',
				"orgTypeVal" => '1000001053'
			),
			2 => array(
				"alias" => "7777777",
				"orgType" => "org-id",
				"orgTypeVal" => "1000001053"
			),
			3 => array(
				"alias" => "alias1",
				"orgType" => "org-id",
				"orgTypeVal" => "1000001053"
			),
			4 => array(
				"alias" => "alias2",
				"orgType" => "org-id",
				"orgTypeVal" => "1000001053"
			)
		);
		$this->orgMappingEmptyXml = <<<ORGMAPPINGEMPTY
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<OrgMappings xmlns="http://www.tracetracker.com/orgMappings"/>
ORGMAPPINGEMPTY;
		$this->orgMappingEmptyXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->orgMappingEmptyXml );

		$this->captureOrgMapXml = <<<ORGMAP
		<OrgMappings xmlns="http://www.tracetracker.com/orgMappings" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.tracetracker.com/orgMappings http://schema.tracetracker.com/orgMappings_3_0.xsd">
		<OrgMapping alias="alias2" orgType="org-id">1000001053</OrgMapping>
		</OrgMappings>
ORGMAP;
		$this->captureOrgMapXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->captureOrgMapXml );

		$this->aboutDetailsResultXml = <<<ABOUT
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<ns7:about xmlns:gtnet="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:ttdata="http://www.tracetracker.com/data" xmlns:ns7="http://schema.tracetracker.com/about">
			<ns7:vendor>TraceTracker</ns7:vendor>
			<ns7:version>
				<ns7:standard>1.0.1</ns7:standard>
				<ns7:vendor>6.0.53</ns7:vendor>
			</ns7:version>
			<ns7:capabilities>
				<ns7:capability>/api/xml/about</ns7:capability>
				<ns7:capability>/api/xml/admin/queue/import</ns7:capability>
				<ns7:capability>/api/xml/event</ns7:capability>
				<ns7:capability>/api/xml/event/epc/{epc}</ns7:capability>
				<ns7:capability>/api/xml/object</ns7:capability>
				<ns7:capability>/api/xml/query/CountEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/ExtendedEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleEventTrace</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleMasterDataQuery</ns7:capability>
			</ns7:capabilities>
			<ns7:properties>
				<ns7:properties name="user">james@tracetracker.com</ns7:properties>
				<ns7:properties name="gan.id">1000000665000019</ns7:properties>
				<ns7:properties name="org.id">1000000665</ns7:properties>
				<ns7:properties name="hub.gap">https://hub.tracetracker.com:9743/gtn/</ns7:properties>
				<ns7:properties name="hub.fullname">Test 5.0 Hub 1</ns7:properties>
				<ns7:properties name="hub.name">com.tracetracker.hub.previous.14</ns7:properties>
				<ns7:properties name="hub.gan.id">0800001005900010</ns7:properties>
				<ns7:properties name="mds.gap">https://test.tracetracker.com:9543/gap/</ns7:properties>
				<ns7:properties name="mds.service.id">MASTERDATA:TEST</ns7:properties>
				<ns7:properties name="mds.console">https://test.tracetracker.com</ns7:properties>
				<ns7:properties name="mds.fullname">Primary Test MDS</ns7:properties>
				<ns7:properties name="mds.gan.id">0800001908600105</ns7:properties>
				<ns7:properties name="node.name">microtracking</ns7:properties>
				<ns7:properties name="node.fullname">EPCIS</ns7:properties>
				<ns7:properties name="org.name"></ns7:properties>
				<ns7:properties name="org.fullname">Microtracking</ns7:properties>
				<ns7:properties name="timezone">Europe/Oslo</ns7:properties>
				<ns7:properties name="tix.downstream-basic">false</ns7:properties>
				<ns7:properties name="cbvValidation">false</ns7:properties>
				<ns7:properties name="epcis.strictConformance">false</ns7:properties>
				<ns7:properties name="api.graph.png.maxwidth">2000</ns7:properties>
				<ns7:properties name="api.graph.png.maxheight">768</ns7:properties>
				<ns7:properties name="api.query.epcis.max-result">1000</ns7:properties>
				<ns7:properties name="api.object.defaultPageSize">20</ns7:properties>
			</ns7:properties>
		</ns7:about>
ABOUT;
		$this->aboutDetailsResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->aboutDetailsResultXml );
		
		$this->aboutDetailsMasterDataXml = <<<ABOUT
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<ns7:about xmlns:gtnet="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:ttdata="http://www.tracetracker.com/data" xmlns:ns7="http://schema.tracetracker.com/about">
			<ns7:vendor>TraceTracker</ns7:vendor>
			<ns7:version>
				<ns7:standard>1.0.1</ns7:standard>
				<ns7:vendor>6.0.53</ns7:vendor>
			</ns7:version>
			<ns7:capabilities>
				<ns7:capability>/api/xml/about</ns7:capability>
				<ns7:capability>/api/xml/admin/queue/import</ns7:capability>
				<ns7:capability>/api/xml/event</ns7:capability>
				<ns7:capability>/api/xml/event/epc/{epc}</ns7:capability>
				<ns7:capability>/api/xml/object</ns7:capability>
				<ns7:capability>/api/xml/query/CountEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/ExtendedEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleEventQuery</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleEventTrace</ns7:capability>
				<ns7:capability>/api/xml/query/SimpleMasterDataQuery</ns7:capability>
			</ns7:capabilities>
			<ns7:properties>
				<ns7:properties name="user">james@tracetracker.com</ns7:properties>
				<ns7:properties name="gan.id">1000000665000019</ns7:properties>
				<ns7:properties name="org.id">1000000665</ns7:properties>
				<ns7:properties name="hub.gap">https://hub.tracetracker.com:9743/gtn/</ns7:properties>
				<ns7:properties name="hub.fullname">Test 5.0 Hub 1</ns7:properties>
				<ns7:properties name="hub.name">com.tracetracker.hub.previous.14</ns7:properties>
				<ns7:properties name="hub.gan.id">0800001005900010</ns7:properties>
				<ns7:properties name="mds.gap">https://test.tracetracker.com:9543/gap/</ns7:properties>
				<ns7:properties name="mds.service.id">MASTERDATA:TEST</ns7:properties>
				<ns7:properties name="mds.console">https://test.tracetracker.com</ns7:properties>
				<ns7:properties name="mds.fullname">Primary Test MDS</ns7:properties>
				<ns7:properties name="mds.gan.id">0800001908600105</ns7:properties>
				<ns7:properties name="node.name">microtracking</ns7:properties>
				<ns7:properties name="node.fullname">EPCIS</ns7:properties>
				<ns7:properties name="org.name"></ns7:properties>
				<ns7:properties name="org.fullname">Microtracking</ns7:properties>
				<ns7:properties name="timezone">Europe/Oslo</ns7:properties>
				<ns7:properties name="tix.downstream-basic">false</ns7:properties>
				<ns7:properties name="cbvValidation">false</ns7:properties>
				<ns7:properties name="epcis.strictConformance">false</ns7:properties>
				<ns7:properties name="api.graph.png.maxwidth">2000</ns7:properties>
				<ns7:properties name="api.graph.png.maxheight">768</ns7:properties>
				<ns7:properties name="api.query.epcis.max-result">1000</ns7:properties>
				<ns7:properties name="api.object.defaultPageSize">20</ns7:properties>
			</ns7:properties>
			<ns7:masterdata>
			    <ns7:organization id="0800002873">
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_name">Tipp Fesil Klæbu</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_active">1</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:latlon_point">63.3291,10.2363</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_resp">MS</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loctype">0</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:start_date">2010-12-10</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_dept">10</ns7:attribute>
			    </ns7:organization>
			    <ns7:node id="0800002873000013">
				<ns7:attribute id="urn:tracetracker:asset:mda:start_date">2010-12-06</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:latlon_point">63.3592,10.2514</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_resp">TO</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_active">1</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_dept">10</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loc_name">Haakon VII's gt - Ny veiprofil og VA</ns7:attribute>
				<ns7:attribute id="urn:tracetracker:asset:mda:loctype">0</ns7:attribute>
			    </ns7:node>
			</ns7:masterdata>
		</ns7:about>
ABOUT;
		$this->aboutDetailsMasterDataArray = array (
				"[0800002873]" => NULL,
				"[urn:tracetracker:asset:mda:loc_name]" => "Haakon VII's gt - Ny veiprofil og VA",
				"[urn:tracetracker:asset:mda:loc_active]" => "1",
				"[urn:tracetracker:asset:mda:latlon_point]" => "63.3592,10.2514",
				"[urn:tracetracker:asset:mda:loc_resp]" => "TO",
				"[urn:tracetracker:asset:mda:loctype]" => "0",
				"[urn:tracetracker:asset:mda:start_date]" => "2010-12-06",
				"[urn:tracetracker:asset:mda:loc_dept]" => "10",
				"[0800002873000013]" => NULL
			);
		
		$this->aboutDetailsMasterDataXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->aboutDetailsMasterDataXml );

		$this->aboutDetailsResult = array(
			'user' => 'james@tracetracker.com',
			'gan.id' => '1000000665000019',
			'org.id' => '1000000665',
			'hub.gap' => 'https://hub.tracetracker.com:9743/gtn/',
			'hub.fullname' => 'Test 5.0 Hub 1',
			'hub.name' => 'com.tracetracker.hub.previous.14',
			'hub.gan.id' => '0800001005900010',
			'mds.gap' => 'https://test.tracetracker.com:9543/gap/',
			'mds.service.id' => 'MASTERDATA:TEST',
			'mds.console' => 'https://test.tracetracker.com',
			'mds.fullname' => 'Primary Test MDS',
			'mds.gan.id' => '0800001908600105',
			'node.name' => 'microtracking',
			'node.fullname' => 'EPCIS',
			'org.name' => '',
			'org.fullname' => 'Microtracking',
			'timezone' => 'Europe/Oslo',
			'tix.downstream-basic' => 'false',
			'cbvValidation' => 'false',
			'epcis.strictConformance' => 'false',
			'api.graph.png.maxwidth' => '2000',
			'api.graph.png.maxheight' => '768',
			'api.query.epcis.max-result' => '1000',
			'api.object.defaultPageSize' => '20'
		);

		$this->pngString = file_get_contents(dirname(dirname(__FILE__)) . '/graphPng.png');
		$this->pngResult = 'data:image/png;base64,77+9UE5HDQoaCgAAAA1JSERSAAAC77+9AAAB77+9CAIAAABtaDJFAABN77+9SURBVHgB77+977+9B3wUVe+/ve+/ve+/vTxFT++/vXrvv70HKO+/vXHvv73vv73vv71ABBTvv71JUVTvv70jNSAlJiAQeg8dQiDvv73vv71CSALvv73vv71ACO+/vQ7vv73vv73vv71LQu+/ve+/ve+/vUXvv73vv73vv73vv73vv73vv73cuu+/vSwh77+9JO+/vTbvv71877+977+9eTs777+977+977+9d34z77+9O2/vv73vv70YL++/vRvvv70AAQhAAAIQ77+9AATcnO+/ve+/ve+/ve+/ve+/vXgQ77+9AAQgAAEIQEAI77+9LDQyQQACEO+/vQAEIO+/vQEB77+9Re+/ve+/ve+/vVxDAAIQ77+9AAQg77+977+977+977+9X3/vv70cOu+/vc+377+9Il/Nn++/vRJMae+/ve+/ve+/vV1s77+977+9RAgRIgTvv70777+9O++/vQhwZDDvv70MExID77+977+977+9T++/ve+/ve+/vWRO77+9fu+/vVDvv70s77+9czXZqdiR77+9Pe+/vWrvv73vv70g77+977+9EiFECO+/vUfvv73vv70G77+9T3PXuO+/vQhBWe+/vQ0n77+9I++/vcKL77+977+9LO+/vRNwDO+/vXQj77+9A1Pvv70OTChg77+977+9RNSZ77+9RO+/ve+/ve+/vQhBWTLvv73vv71R77+9P8mK77+977+9Ae+/vQPvv70Q77+977+977+977+9QSTvv73vv71kJO+/vRHvv70R77+9USbvv70O77+9JV1Q77+977+9EO+/vU/vv73vv73vv70ncXHElC5NDu+/ve+/vRHvv70DExHvv71I77+977+977+977+9QQTvv70jHzUGSlASAihL77+9O++/ve+/vd6h77+9BWVBWe+/vTBE77+977+977+97puj77+977+977+9ATTvv73vv71k77+946GWKR0JQO+/ve+/vTXvv73vv70xPO+/vd2PUO+/vT/Jiu+/vcaOZO+/vUhUXe+/vdyR0p0s77+9Xe+/vSkdCe+/vcex77+9Ce+/ve+/vXzvv71BWRwPC++/vR4/URbvv73vv71PBO+/vTzvv708cnnlkZsrTu+/vT3vv70VZ++/ve+/ve+/vVvvv71mckrvv70lXVDvv73vv70R77+977+977+9CltRc8SULk0ZyZRU77+9VO+/ve+/vR3vv70EODJwZO+/ve+/vSMD77+977+977+9E++/vVvDqu+/ve+/ve+/vS/vv70ZZCQgAAEIQAACEO+/ve+/vRsSQFnvv73vv73vv73vv70NNw9F77+9AAQgAAEIQEARQFlQFghAAAIQ77+9AAQ0IO+/ve+/vWjvv73vv73vv71rCEAAAhDvv70ABH5X77+9X++/ve+/vQAEIAABCEAAAm5JQO+/vRrvv73vv73vv70b77+9QkEAAhDvv70ABCDvv70H77+9PykL77+9TRDvv70ABCAAAQhA77+977+9CdCX77+977+9LBDvv70ABCAAAQhoQABl77+9YCPvv73vv73vv71SNghAAAIQ77+9QO+/vRBAWVAWCEAAAhDvv70ABDQg77+977+9aO+/ve+/ve+/ve+/vV5ZCgQgAAEIQO+/ve+/vQnvv70sKAsEIAABCEAAAhoQQFk077+9SO+/vey8lA0CEO+/vQAEIO+/vT0EUBbvv70FAhDvv70ABCAAAQ0I77+9LBps77+977+977+9V++/vQIBCEAAAhBwZwIoC++/vQIBCEAAAhDvv73vv70GBFAWDTbvv707Oy9l77+9AAQgAAEIZA8B77+9BWXvv70ABCAAAQhAQAMCKO+/vQYbKXvslaVAAAIQ77+9AATcmQDKgu+/vUAAAhDvv70ABCDvv70BAe+/vUXvv73vv73vv70F77+9Ve+/ve+/ve+/ve+/ve+/vV8u77+977+977+9f++/ve+/ve+/ve+/vSAzZn5ic8qs77+9Ze+/vU4CAu+/ve+/ve+/vR9v77+977+9Pe+/ve+/vURsRj9lND7dkjtOLGPvv70v77+9du+/vXRL77+9SCcE77+9RS3vv73vv73vv73vv70ySO+/ve+/vWR377+977+9bO+/ve+/ve+/ve+/vS8k77+977+9J1/vv70WLxnvv71rFu+/ve+/ve+/vWLvv73vv73vv70o77+977+9Ku+/vQRc77+977+9I++/vU5N77+977+977+9W++/vQ/vv73vv73vv70J77+977+977+9U++/ve+/vWVKCO+/vSzvv73vv70HdkblvKscHCdWY++/vSUzwpvvv73vv73vv70477+977+91KXvv73vv73vv71k2J1677+977+977+9ZO+/vXHvv73vv70v77+9ajBo77+9LRDvv71w77+977+91bXvv71sWEErBUZZPFlZVGTvv73vv73vv73Pku+/ve+/vR81Z++/vUo3HzHvv73vv73vv703Ze+/ve+/ve+/ve+/vXtU77+957e+Se+/vXrvv73vv703HBPvv70HzZR9Se+/ve+/vU/vv73vv71m77+977+9Sjjvv70sPwVMWyrvv73vv71VY++/vcqNTwjvv73vv73vv70Z77+9KkPvv73vv71jfO+/vT/vv73vv73vv71QGinNr++/ve+/vRjvv73vv71fM++/ve+/vR0Qce+/ve+/ve+/vV9/77+9Q++/ve+/ve+/vVTvv73vv73vv73vv71ZfjMfGe+/vQ3vv73vv73vv71cEu+/vSHvv71y77+977+9eTBsOjxG77+977+977+9zK3vv70S77+977+977+91K/vv73vv70777+9A++/ve+/ve+/vd2R77+9cXY177+977+9T++/vWw9eu+/vUrvv73vv73vv73FnhTvv73vv70pYu+/vWbvv70MCVdz77+9HO+/vT/vv73vv711WO+/ve+/vQ/vv73vv70lPu+/ve+/vd2jfnLvv71Y77+9x7ZU77+977+977+9H++/ve+/ve+/ve+/ve+/vRNl77+9cGV577+977+977+977+9O++/vUrvv71JLAbvv71fKyd577+977+977+977+977+9YXNlOHDvv73vv70K77+9XSnvv70l77+9ZV/vv73vv70T77+9T++/ve+/vUNn77+9DO+/vVnvv71Gyqc577+9Nu2Ys0wW77+977+9Tu+/vV3vv71h2pzvv70EBO+/ve+/ve+/vW3vv73vv71yza/vv73vv71p77+9dO+/ve+/ve+/vSp0GmsWUu+/ve+/vR5kG8my77+9SBUl77+92Llr77+977+977+9HO+/vSPvv73vv71VOnt2SXPvv70kMkNALtipY++/vUwsCe+/ve+/ve+/vTLvv73vv70xIRPvv709cVFE77+90ZAo77+977+9dA/vv71mVnZHQu+/ve+/vdWU77+9ek/vv73vv71J77+977+977+9Xe+/ve+/vUvvv73vv70c77+977+9fs6kfWwuaO+/ve+/ve+/vVXvv73vv73vv73vv71ELu+/ve+/vTxiZXbvv71S77+9Oe+/ve+/ve+/ve+/vRNl77+9WGXvv73vv70T0Z7vv71m77+977+9He+/vUjvv73vv70G77+977+9B++/vTPvv702QEnvv7091pzvv70xYe+/vVfvv71laE7smLPvv73vv73vv71w77+9fe+/ve+/ve+/vQYCEn7vv71P77+977+977+975iQQ++/ve+/vWNnS++/ve+/ve+/vWhK77+9du+/ve+/vVnvv70577+9RyZbNWXvv73vv73vv73vv71ySWTvv73vv73vv73vv70t77+977+94ri5M3MANGPvv71xdu+/ve+/ve+/vQ3vv70+fe+/vSPvv73vv73HnO+/vUnvv70MQu+/ve+/ve+/ve+/vWjvv73vv70277+9cnbvv71YJxnvv73vv71x77+9BO+/ve+/ve+/ve+/vWIXZ2Zo77+9eAlc77+9LW3vv73vv70277+91Yzvv73vv71mQu+/vWVma++/ve+/vTFm77+9MWfvv70nM2Hvv71AAgLvv71G77+9Lu+/vcyvThLvv73vv71IF++/vSXvv70P77+9QjpOae+/vUfvv71k77+977+977+977+977+977+977+977+977+9ce+/vXEc77+9MnMwE3YFMMeb77+9IO+/vUkCR++/vV/vv702ZjXvv73vv70LQzLvv70tZO+/vW3vv73vv70d77+977+9HRPvv73vv73blu+/ve+/vW7vv73vv71M77+977+9OO+/vWs377+977+9YG7vv73vv71t77+977+9Au+/ve+/vSfHuWwL77+9Pmnvv70lNyrvv700SErvv71077+9C0PSqChN77+9Mu+/vQxcCW5pWu+/ve+/vUlz77+9Xe+/vTTvv73vv71k77+9Uu+/vWxO45iz77+977+977+9cO+/ve+/ve+/vSTvv73vv73vv71d77+977+9X++/vSQETu+/vS7vv71yKu+/vSg5Tu+/vWZv77+92a9FTe+/ve+/vR/vv73vv73vv73vv73vv70d77+977+977+9OGZ1V++/ve+/ve+/vRQS77+9ISDvv71377+977+9Ju+/vVsOeu+/vRBVVXM5Mu+/vT3unbx8Qx02f++/ve+/ve+/vWp677+977+9aG53x4Tvv73vv73vv71F77+9Jhbvv70477+977+9OO+/vWs7RhxLDu+/vVLvv707Tu+/vRjvv73vv73vv73vv73vv71tV9C2PG7vv71GWXLvv73vv71I77+977+9de+/ve+/vT5577+977+977+9cu+/vdOM4K6TEmTvv73vv70j77+977+9YyQt77+9aM2v77+9Vzvvv70EOO+/vWxObybvv70k77+9KUbvv70iYBd+77+9V++/vQnvv70IaUrvv73jlKLvv71SRe+/vV5g77+977+977+9H++/ve+/ve+/vWnvv70d77+977+977+9OGZ1V++/ve+/ve+/vRQS77+9JO+/vW5y77+9Dtem77+9yIzvv73vv71t77+9exIbYu+/ve+/vVfvv70w77+977+9cTvvv73vv73vv70x77+9OO+/vSrvv71MKX9y77+9de+/ve+/ve+/ve+/vTFOEnLbhO+/ve+/vTJ777+9yrwZTe+/vRjvv73vv70T267vv73vv73HrT5RFu+/vVQW77+9CjIKAwEIQO+/vVMJ77+9XB4577+977+95bWzOO+/ve+/vRxZLu+/vV4z77+9LCgLBCAAAQhA77+977+9Ce+/ve+/vVbvv71Xfu+/ve+/vRnvv70877+977+977+977+977+977+9au+/vVLvv70sLFrvv71ZUO+/ve+/vQ5TfTc2Je+/vQAEIAABCO+/vUsAZUFZIAABCEAAAhDQgADKou+/vUbvv73XiCk5BCAAAQhA77+9VQRQFu+/vQUCEO+/vQAEIAABDQjvv70sGmwkV++/vSnvv71AAAIQ77+9AATvv70l77+977+977+9LBDvv70ABCAAAQhoQABl77+9YCPvv71rxJQcAhDvv70ABCDvv70qAigL77+9AgEIQAACEO+/ve+/vQYEUBYNNu+/ve+/ve+/ve+/vXwgAAEIQAAC77+9EkBZUBYIQAACEO+/vQAENCDvv73vv71o77+977+977+9NWJKDgEIQAACEHAVAe+/vQVl77+9AAQgAAEIQEADAu+/vSvvv73vv73vv73vv70yQAACEO+/vQAEIO+/vRIC77+977+9fXLvv73vv73vv70n77+9Pjohw5Ub77+977+977+977+9Xu+/ve+/vXLvv71a77+9xavvv70vXD12Pu+/ve+/ve+/vStH77+9XT5677+977+977+9M++/ve+/ve+/ve+/vXjvv73vv71FeS3vv73vv71L77+977+977+977+9z77vv73vv73vv73vv73vv73vv73fuu+/ve+/ve+/vTfvv73vv73mo5vvv718fO+/ve+/vU/vv73vv73vv73vv71b77+9fe+/ve+/ve+/ve+/vX3vv73vv73vv73vv73vv73vv73Ftz9+77+977+9T19+77+977+977+977+9f++/ve+/ve+/vV9u77+977+9369/77+977+9Uwfvv71O77+977+977+9ahDvv70ABCAAARcTQFlcK08o77+977+9A++/vSViTiYQ77+9AAQg77+9AQRQFu+/vQXJgAAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIAABCHgAAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/ve+/vQNODlgFCEAAAhDvv71IAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv70o77+977+9DgEIQAACHkAAZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/vQNWAQIQ77+9AAQsEkBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEwt77+9Oe+/vUMAAhDvv73vv70HEEBZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEw977+977+977+9Ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71i77+977+9EO+/vQAEIO+/vQEEUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIUw84OWAVIAABCEDvv70iAe+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdSi77+9MzsEIO+/vR3vv73kvZvvv73vv73vv73vv71677+977+9du+/vUjvv73vv73vv70AyoLvv73vv70sEO+/vQAE3Ivvv73vv71rH1fvv71b77+9Zu+/ve+/vUYs6JqZ77+9ae+/ve+/vXUbNe+/ve+/ve+/ve+/ve+/ve+/vSPvv73vv73vv70s77+9de+/ve+/vW4X77+977+9EO+/ve+/ve+/vQlELe+/ve+/vUfvv70n77+977+977+977+9GV/vv71p77+977+977+977+97L+f77+977+9dO+/ve+/vUtC77+9bkUAZUFZUBYIQAACbkTvv714Wu+/vQvvv73vv71477+977+977+9SV9R77+977+977+9au+/vWLvv73vv70777+977+977+9VRVLYVxLAGVBWe+/ve+/vVDvv73vv73vv70mNwhAQEcC77+9RnZ577+9ZO+/ve+/ve+/vRU1ce+/vRrvv71077+977+977+9RO+/vUc677+9NWXvv70MAe+/vQVlQVkgAAEI77+9C++/vW0pB++/vRXvv73vv70177+9dRbvv73vv71nRO+/vXwF77+977+92LQtM++/vR/vv73vv71IAGVBWe+/ve+/vVDvv73vv73vv71D77+9IQAB77+9Eu+/ve+/ve+/ve+/vUp177+9ZO+/vVfvv70s77+9W9Ws07Dvv73vv73vv71XXVsqcnMTAigLyoLvv71AAAIQcAsCce+/vQnvv73vv717bO+/ve+/vQ5ZVhbvv73vv71b77+9cO+/vWlzE9yk77+977+9GO+/vSXvv73vv73vv70sbnHvv71ybVjvv70bBCDvv70d77+91LRrZe+/ve+/ve+/vd+hZu+/vX1F77+977+93bvvv71LXl4HTu+/vdeOAAXvv70jAe+/vQVlQVkgAAEI77+9PO+/ve+/ve+/vVHvv71ffEpuV++/ve+/vSwye++/vTLvv70H77+9HC3vv73vv70d77+9QCbQiwDKgu+/ve+/ve+/ve+/vUrvv71977+977+9QgACLifvv73vv73sqafvv73vv73vv70z77+9Pe+/ve+/vSI5dB3vv71+77+9woU277+9Pe+/ve+/vXLvv71h77+9EkBZUBbvv70FAhDvv71ADhNo16tV77+9Ku+/vVzvv70rKu+/ve+/vXUq77+9U++/ve+/veGzl3Lvv73vv71l77+977+9Je+/ve+/ve+/vSw5fO+/vXJtQO+/vRsEIO+/vQvvv73vv73vv73vv73vv73vv71b0L3fgO+/vW/vv70tbxPvv70NbO+/vUJl77+9Nu+/ve+/ve+/ve+/vSdP77+9YiXvv73vv71877+9Vu+/ve+/ve+/ve+/vSMjV2zvv718Mu+/vcaZ77+977+9yqALJe+/vWlLAGVBWe+/vXUhAAEIZAfvv71DZy7vv70lLe+/vTdkeO+/vXoNXirvv71V77+9Wu+/vQ/vv73vv73vv70yY++/ve+/vUPHh++/vRnvv71V77+977+977+977+9ZWRi77+977+977+977+9W++/vWHvv73vv73vv73vv73vv73vv73dtm3vv73vv73vv73vv73vv73vv73vv71DDxkPP2zvv71+77+9eO+/ve+/ve+/ve+/ve+/ve+/vRY+Ze+/ve+/vU3vv73vv73vv71TLTF0fMmOGO+/ve+/ve+/vSzvv71RFu+/vUXvv70w77+9QmQzCwQg77+977+9BO+/ve+/vSjvv70r77+9DAkc06BJ77+9Ui/vv73vv71Q77+9cu+/ve+/ve+/ve+/vU/vv73ZsO+/ve+/vV3vv71OXO+/vSEvCXJVX++/ve+/ve+/ve+/vQs+77+977+977+977+9JHnvv73Qiu+/vVvVsu+/vWVl17Hvv715S++/vQ0YOu+/ve+/vV/vv73vv71vVHrvv73vv73vv71577+9Gu+/vQvvv71f77+977+9F++/ve+/vTTvv70977+977+9xKhJKzbvv71P77+977+9dlp13aUD77+977+9NUfvv70sKAvvv70CAQhA77+9NQTvv70877+977+977+9EhgS3qzvv73vv70v77+9e++/ve+/ve+/vRXvv73vv73vv73vv73vv70wedWWHSfvv71+bO+/vSnvv71X77+9Se+/vUnvv70YM++/vUjvv71n77+977+9MRTvv73vv71vSS/vv70+77+977+977+977+9KGVZ77+9du+/ve+/vWrtjr3SnO+/ve+/ve+/vVkRKe+/ve+/vdS177+977+977+9Uu+/vRcvCgob06FL77+977+977+9au+/ve+/vSpY77+977+9Ue+/ve+/vVHvv73Ss828a++/ve+/ve+/vWFSVNiqTWsP77+9OnPvv73vv73Hv3vvv73vv73vv73vv70m77+93JBAWVAW77+9HO+/vXLvv73vv73vv706QgACdgTvv70KWe+/vX3vv73vv73Jke+/vX/vv71X77+9fAXvv73vv73lmrRsNSI4VCwh77+977+9de+/ve+/vc2v77+9UXYcSRXvv73vv71W77+977+977+977+9b++/vX9YZO+/vUbvv70377+9P++/ve+/ve+/ve+/vW4lS3spX++/ve+/vWzvv73vv73vv71XZO+/ve+/vSnvv73vv70sce+/ve+/vX3vv71EU2Jk77+90qXvv73vv73vv73fm1Xvv71jDu+/vTnvv73vv716xbjvv71BPe+/vXXvv71u77+9Tu+/vcqF77+9Fu+/ve+/vXjvv73vv73vv71WK++/ve+/ve+/ve+/ve+/vUM7RUwLWe+/vW7FsQvvv71O77+9fXTvv73vv70MGe+/ve+/ve+/ve+/vSRcRQBlQVlQFghAAAJ3QWDTvkMTY2J9O++/ve+/vVbvv71qSe+/ve+/ve+/vTV6L2BE77+977+9Ze+/vW5X77+9Ge+/vUDvv73vv71IR++/ve+/vUdP77+977+9LFnvv71JHGXvv73eg++/ve+/ve+/ve+/ve+/vTLvv73vv70Cee+/vTzvv702JGnvv71cEgrvv73vv73vv73vv71l77+977+977+9GRUp77+977+9NWnvv70R77+977+977+9Snnvv73vv73vv71L77+9RO+/ve+/ve+/ve+/vV4w77+9MHTvv73vv71977+9J++/ve+/vV8VGTvvv73vv70g77+9Nu+/vd+sUe+/vXDvv73Shu+/ve+/ve+/ve+/vduF77+977+9Vu+/vRfvv706IiYoae+/ve+/vV1HDu+/ve+/vXJd2plO77+977+9SO+/vUwGKBhv77+9AMqC77+977+9xaHvv71K77+9MS8EIO+/vSkBce+/ve+/ve+/ve+/vV1677+977+9Wu+/vQ3vv70277+91rt1ewcM77+977+977+977+977+9E2ZtHUVaNWQQWe+/vXxEa++/vScnHDrvv73vv73vv71c77+9bO+/ve+/ve+/vTZt06JO77+9Ru+/vVcW77+9SBbvv71w77+9LO+/ve+/ve+/vTLvv73EiO+/ve+/ve+/ve+/vWJvPXhUXU7vv73vv73vv71NRe+/ve+/ve+/vS/vv71Y77+9Impm77+977+977+9Lu+/vT3vv703aO+/vULvv70qD1bvv71o77+9Uzvvv73vv73vv71rAUNb77+9Te+/ve+/vWDZrC3vv71277+9XExL77+9fE1uU++/ve+/ve+/vW5xfO+/vQIB77+9BWVBWSAAAQjvv73vv73vv73vv71T77+9ZiYs77+9NWDQm++/ve+/vSvvv71S77+977+9Wu+/ve+/ve+/ve+/ve+/ve+/ve+/vX3vv71URtWM77+977+977+9IyIlcu+/vUUaLe+/ve+/vRdH77+9Ngzvv70a77+977+9Yu+/ve+/vTRvFCzvv71077+977+977+9HDRreO+/ve+/vQXvv73vv70nKGXvv73vv73vv71lfu+/vV/vv71K77+9Wu+/ve+/ve+/vWtYZkvvv73vv73vv73vv709ce+/ve+/ve+/ve+/vSfvv73vv704eu+/ve+/ve+/vV1bZu+/vUfvv70N77+90bNP77+977+9Pi/vv73vv73WgzVrGu+/vWs/77+977+977+95YCh77+9J0Tvv73vv709L3zvv73vv711B07vv70+fu+/ve+/vVw177+977+9MQbvv73vv71T77+9Ze+/ve+/ve+/vX51J38p77+977+977+9XO+/vXrvv73vv73vv71j77+9047vv73vv71y77+977+977+977+9Zy8fOXPvv73Ime+/ve+/vU9f77+977+977+977+977+9T29e77+977+977+9a++/vd+677+977+977+9G198fe+/ve+/vW8+77+977+977+977+9N++/ve+/ve+/ve+/ve+/vT7vv73vv73vv73vv73vv73vv70n14rvv73vv73vv73vv71S77+9ETIY77+9X0bvv70ZDwEIQO+/ve+/vQgcOXdZ77+977+9Ae+/vUdKE++/vVzvv73vv73vv71677+9Du+/ve+/vSZP77+977+977+977+9ESfvv70U77+9UO+/vSLvv70RSWs2SO+/vS5V77+977+9Ou+/vWPvv71hUVEv77+9KnLvv70NLe+/vRfvv73vv71S77+977+9Xxd/77+9K++/vRbvv73vv71hQ++/vVoaXWRN77+977+9ybrvv73vv71JIjFy77+9SyRG77+9VE5c77+977+9eumqtO+/vSxYOmt8RF9R77+9Dh96NWvvv73vv71uXe+/vVHvv70HfXzvv70bNO+/vXbvv71477+92Ljvv71laxLvv70dTzly77+9wrHvv70877+9Hu+/ve+/vRHvv71eY++/ve+/vQTKkmUHQlky77+977+9eu+/vS3vv70WAu+/vUdAenJI77+977+9YWPvv701bt6ydO+/ve+/ve+/ve+/vVbvv73vv71v77+90Igo77+9Difvv73vv71yFO+/vW7vv70cRXXvv70VR++/ve+/vVzvv73Iq++/ve+/ve+/ve+/ve+/vd6V77+9BO+/vQ9877+9aO+/ve+/ve+/ve+/vUpZ77+9XO+/vXJtUSU377+9W++/ve+/ve+/vSt3J++/ve+/vXVEYu+/vV/vv70qEu+/vXJJ77+9Ae+/vWw/77+9d++/ve+/ve+/ve+/vTPvv73vv70Kat6nfxXvv70PCjVtajRvbnTvv73vv73vv73vv73vv71KYRPvv73vv73vv70IWO+/vXzvv73vv73vv71bD++/vTx777+977+977+977+977+977+977+977+977+9Amvvv70hypJlKXE+I8qC77+9QAAC77+9SEDvv73vv71XbO+/vRYUPu+/vWXvv712ZV4pX++/ve+/vVdb77+977+9dnTvv70E77+9D++/vSnvv706TBxFGg/vv71H77+9bUdJXi/vv73vv73vv70xMj7vv71ZXDJ+77+977+9HQXvv73vv703ZG7vv71MWktwUkDvv73vv73vv70bFhTvv718Re+/vT1cUu+/vSxnYkrvv73vv73vv70rEiPvv71EaNSVMu+/vRjvv73vv71777+9Yu+/vUjvv73vv73vv73Upe+/vQkz77+9Ru+/vU7vv70JGFzvv71r77+9Z31877+977+9b29077+9f3LQkO+/ve+/ve+/vRrvv73vv73ol7gsau+/ve+/vQ1777+977+9OHjvv73vv71c77+977+977+9DjpZXgXvv73vv73vv71U77+9bO+/ve+/vWIu77+9ecWv77+977+9KO+/vTse77+977+9at+jMBDvv702AlJH77+9Te+/vW7vv73vv73vv70077+9SFNK77+9Zi3vv70GBS9a77+977+977+977+9DBtFVF0rXnLvv70m77+9NRvvv73vv73vv71KV++/ve+/ve+/vWtHcWTvv73Yu1nvv71m77+9ZVJZfHt277+9XO+/ve+/ve+/ve+/ve+/veWrs++/ve+/ve+/ve+/ve+/vRtj27dX77+9Ve+/ve+/vVF9e++/ve+/ve+/vSJXN++/ve+/ve+/vXzvv73MhT1H77+977+93rh8Vu+/ve+/vUnvv71+77+9Y2rvv73vv73vv70vf++/vTzvv707G33vv708OXzvv73Loe+/ve+/vUfvv73vv73vv71NDF3vv71+77+977+9A++/ve+/ve+/ve+/vdWoC07vv70n77+9K++/ve+/vV9NdUBZXO+/vUcoC++/vQIBCO+/vRgB77+977+9ImJnde+/ve+/vV0677+9SO+/ve+/vXcbNBwwbETvv73vv70V77+9VSXvv73vv71K77+9Uu+/ve+/vSIz77+9JSFxFFXvv71m77+91p7vv70ydO+/vXjvv70CbFZU77+9SUTvv73vv71U77+9Iu+/ve+/ve+/vTLvv73vv718HCVG77+977+977+9Yu+/vW/vv71I77+977+977+977+9D++/ve+/vWQOHFzvv70+aWbvv73vv73Jke+/vceM77+9OXxk77+9Pn3vv73vv73vv71j77+977+977+9JzDvv71477+977+9Wu+/vTHvv73vv73vv70PWu+/vSZx77+977+977+977+977+977+9SGPvv73vv717Twvvv73Nme+/vQHvv73vv73vv70sOXZ477+977+977+9Z3EQ77+9PAJ7Uk5N77+9O++/vWvvv71+clPvv73vv73vv73vv73vv73btXvvv70P77+9MX/vv73vv70P77+9aGXvv73vv73vv70VCu+/vSjvv73vv71sFm7vv73vv70of9eO77+9Kkoe77+977+9XCQz77+9cu+/ve+/ve+/vXUu15bvv73vv73vv73JphFTUVfvv73vv71dZO+/ve+/ve+/ve+/vW4xF++/vd6+77+977+9enrvv73vv73vv73vv73vv70yd++/ve+/vSnvv70f77+977+9BO+/vSk+ZGjvv70hQ++/ve+/vSPvv70E77+9FO+/vTjvv71mZEzvv71Z77+9Ixbvv73vv73vv71m77+977+9TXsOSGPvv71077+9dXnvv73vv70tQ++/vcW177+9Yu+/vUYrCwIEAQjvv71DAgdPX++/ve+/vXBJ77+9QUPfrlNPHEUe77+90rlH5L6A77+9Ou+/ve+/vVdV77+977+9cCLvv70i77+9KO+/vVHvv71Z77+977+977+9Pe+/ve+/ve+/vUreu9ms77+9Mu+/vVDvv70s77+9cO+/ve+/vVTZnO+/ve+/vcSo77+9Zysx77+9DCMX77+977+9HD/vv71577+9AWll77+9PS8wMu+/ve+/vShLaFjRoO+/vQfGjDHGjXsgLO+/vdCk77+977+9U++/vRpH77+977+977+9Te+/ve+/vXRt77+977+9He+/vXceSe+/vXnvv715de+/ve+/vTgzAO+/ve+/ve+/vSzfvs6cMjPvv71DJ07vv703OX/vv73vv73vv73vv71977+977+977+977+977+977+9xbc/fu+/ve+/vU9ffu+/ve+/ve+/ve+/vX82MzHvv714D0vvv70s77+977+9YO+/ve+/vXBnRgjvv71LQE7vv73vv71zxqDvv73vv73vv703bnLvv73Ngu+/ve+/vXzQqcuE77+977+977+977+977+977+9SklnDnHvv71s77+977+977+9SRnvv73vv70kT++/ve+/vVrvv71C77+977+977+9NO+/vVLvv71u77+977+9Vu+/ve+/vdG877+9ce+/vV3vv73vv71B77+9I++/vcy+77+9R++/vV3vv70LQzsPH1/vv71977+977+977+9zJw7NGrvv73vv73vv70pb07vv71UYsKE77+9J040Jk16YErvv73TkVNf77+9ElUvMu+/vW/arO+/ve+/vSVJKzZs77+9xpjvv73vv70Q77+977+977+9Yu+/vSAiUx3vv70o77+9NCNV77+9U17FjG9I77+977+9Te+/vSND77+977+977+977+977+9UC1H77+9U2PajGnvv73vv70077+977+926hpU++/vUXvv73vv73vv73vv70gLhDvv71AFglIV0rvv73vv71G77+9C2vvv73vv71aXu+/vSMv77+9ae+/ve+/vRs8aUrvv73vv71dcu+/vc6o2pBqLEdu77+9yag8Fu+/vUct77+977+9R++/vScyf8eQ77+9TFFeBC1X77+9LC5X77+977+977+9G++/ve+/vV3vv712EiPvv70mHTh1bu+/vXRX77+9Js+J77+977+977+9Mywy77+977+9KVPvv71FRhXvv73vv71+LCbGmD7vv73vv73vv71pBe+/vWLvv71O77+977+977+977+9KW0j77+9De+/vR43e++/ve+/ve+/ve+/ve+/vTvvv70x77+9HSQmM++/vRLvv70Q77+977+904/vv70xU++/vXNlce+/vVLvv71e77+9G++/ve+/ve+/ve+/vR3vv71477+977+977+9VXwrDO+/ve+vlO+/ve+/vQzvv73vv73vv70+77+9PHnvv71677+9HO+/vSwjNO+/vX7vv70NAQhkJwFp77+9X++/vXVn77+9xIhW77+9P++/vVcf77+9C++/ve+/vXrvv70eFRLvv71077+9Zifvv73vv73vv73PrT0uZ3U8LU0eJXfvv73vv71l77+9G++/ve+/ve+/vWJFdx7vv73vv73vv71b77+977+9Tu+/vWQoQe+/vV7vv73vv73uspY777+977+9cu+/vQjvv73vv71BSV4V77+9L++/ve+/vWZ577+9zobvv73vv73vv70WRO+/vQ7vv70c77+9OjLvv73NmGnvv71n77+977+9O3fvv70RH+G7j3sidu+/ve+/vSPvv71eD++/ve+/vWjvv73vv73vv71T77+9R82Y77+9YO+/ve+/vQ1b77+9HTp877+9Uu+/ve+/ve+/vSw077+9Vu+/vSXvv73vv708Vu+/ve+/vTLvv71eUjoi77+9Pe+/vduJ77+977+977+977+977+977+977+977+9fe+/vVBNLF0m77+9Nifvv73vv73vv71Vf++/vWjvv73vv73vv71nL++/ve+/vW/vv71V77+977+9fu+/ve+/vdaP77+977+977+977+9Qe+/ve+/vcOF77+9LO+/vVnvv73vv70O77+9ciHvv70jBDbvv705MD5q77+9z4fvv73vv71C77+9XO+/vWnvv71e77+977+977+977+977+977+9OE7vv73OlUrvv73vv73vv70e77+977+9D3fvv73vv73vv73vv70A77+977+977+977+9fO+/ve+/vWbVku+/vUTvv70a77+9dO+/ve+/vVPvv73vv73vv70uJ2nvv73vv71d77+9GO+/vRIj77+977+9TO+/ve+/vXPvv73vv73vv73vv717Fyfvv73vv71LTO+/ve+/vR4xcXLvv73vv73Imu+/vWJL77+977+977+9W++/ve+/ve+/vSVL77+977+977+977+9Z++/vX5+77+977+9Cu+/ve+/vWrvv70O77+9CQodGzFt77+977+9RUvvv71u373vv71E77+93b1t77+9YD3vv73vv73vv71U77+977+977+9EwUeK++/ve+/ve+/vU4T77+9zIBp0K/vv70y77+9Uk1v77+9S++/vV41zJ/vv71OeV8J77+9P18q3LNP77+9G19+77+977+977+9yoLvv71AAALvv70T77+9cTglcmZc77+97r2qVu+/vSnvv71m36lb77+977+977+9YXMWLe+/vVPhjI7vv73mibLvv70rZgXjkY5iS2Bb77+977+9fO+/ve+/vWbvv70dQz0j77+977+9K++/vV/vv73vv71n77+9IWknBGzvv73FiATvv71gKzHvv71P77+977+977+977+9C1fvv73vv70eNyt877+977+977+977+9VhMj77+9T++/vS05b37vv71V77+977+9X++/ve+/vVjvv73ssbnvv71FYu+/ve+/vRQcUnXvv73vv73vv73vv71H77+9HRs+MWZOfO+/ve+/vXVyRSnvv73vv711J++/ve+/ve+/vU/vv70q77+977+9eVMffu+/vW/vv73vv70uVe+/vUnvv73vv73avWJe77+9GRzvv71JXQ8SX3nvv71F77+977+9M31NZe+/vdah77+9Gu+/vWFI77+977+9T++/vd+6Zz/Kgu+/vVBdQSDvv70S77+9d++/vUzvv73vv73vv70e77+9B8qN77+977+9KDVq77+91a1v77+9ae+/vQlObmlR77+977+977+977+9Hu+/ve+/ve+/ve+/ve+/vTXvv71T77+9Du+/ve+/ve+/vVXvv73vv73ble+/ve+/vTHvv73vv73vv71N77+9blXvv71O77+977+9Thrvv73vv70D77+977+9BXbvv70Y77+9UTHvv73vv71e77+9fe+/ve+/ve+/vS0777+9Fy/vv70cPX3vv73vv73vv70jAu+/ve+/vQvvv70uypLvv73vv73vv73vv73vv70Pb++/vWbvv71b77+977+9xIVPRU/vv713YO+/vSt977+977+977+977+977+9Z2hg77+977+9aTPvv70vW++/ve+/vdCx77+977+9ViXvv71RWe+/ve+/vU8rVu+/ve+/vX8Wfe+/vXrvv73vv70y77+9bVLvv717VAMzbO+/ve+/vV1TNe+/ve+/ve+/vV/vv70c77+9Pu+/ve+/vRrvv71877+977+977+9Qu+/vWnvv71G77+977+9za5+77+977+977+9HUNcGMq9R++/vWzvv73vv71YHATvv73vv73vv73hs5fvv70uXu+/vX/vv70Iee+/ve+/vThK77+916t377+977+9Y8qM77+977+977+977+977+9JFJD77+977+977+9DgfSlCLvv73vv71u77+977+9FCdr4aqf77+977+9Ex7vv73vv73vv73vv70ZHe+/ve+/ve+/vW4T77+977+977+9YO+/ve+/ve+/ve+/vSbvv73vv71I77+9Y9u3VzrEiEzvv71KzK7vv73vv71yYWhO77+977+977+977+977+977+977+977+9b2Dvv71R77+9K0/vv70Q77+9eXrDhkcOHDDvv73vv73vv73vv73vv70VeWfvv70sHDzvv71477+9XhU6d2vSpWfvv70x77+9E2fvv71PXO+/vWXvv73vv71K77+977+977+977+9Gu+/ve+/ve+/vUce77+90qDvv71S77+915vvv71a1rvvv73vv73vv73vv73IkVbvv71XWu+/ve+/ve+/ve+/vUxL77+977+977+925QbEn/vv73vv70QEjPvv73vv71ZKGHvv71S77+9Je+/vQjvv73Zne+/vUrvv71D77+9BxPvv70SGO+/ve+/ve+/ve+/vUcee++/vXDvv73aoe+/ve+/vcqD77+977+9ce+/ve+/vStWatehU3hk77+9dHJ0UlR1Fu+/ve+/vdqjHjXvv73vv70d77+9FlRq2rXvv73vv71K77+977+9UO+/vW4177+9bnrvv73vv73vv71e77+977+977+977+977+9ItquRW5IO++/ve+/vTMX77+9JWbvv73vv73vv73vv73vv73vv73vv70ODe+/vdmvV++/ve+/vXXvv70OLztx0osLF++/vd+277+9b++/ve+/vcaxY++/vW3vv73vv71w77+977+977+9Ie+/ve+/ve+/vdmraDvvv70afu+/vXzvv73vv71QU2fvv70t37jVue+/ve+/vSnLnu+/vdSC77+9FShW77+9We+/vSvvv71TLg9J77+9Wu+/ve+/ve+/vQLvv71R77+977+9Pu+/vUbvv73vv701NyPHu09977+9MmUuXO+/ve+/ve+/ve+/vSzvv73vv71477+977+9SO+/vTJv77+9ASvvv73vv73vv70bdu+/vVzvv73vv73vv70RIdKvc++/ve+/vS3vv73vv73vv73lhYLvv71aQXnvv73vv71377+977+9Y++/vU/vv73vv70TTi7vv73vv73vv73vv71j77+9FXDvv73HuO+/vUjvv70GRu+/vSrvv73vv71Tcu+/ve+/vVnvv71kOVHvv71McXnvv73vv71Ubznvv70i77+9cO+/ve+/ve+/ve+/vd6gJGl1WVM677+977+977+9SO+/vcqI77+977+977+977+977+977+977+977+9Vu+/ve+/ve+/vQkJLTI3Pu+/ve+/ve+/vX87c++/ve+/vXPvv73vv73bte+/ve+/vSVLHw0L77+9171H77+9dj5e77+9bVrvv70bMmzFmCVrN++/vTp277+9RGrvv70sTTs2eu+/ve+/ve+/ve+/ve+/vd6r77+977+9Imnvv70877+9G++/vVx177+977+977+977+977+977+9UV1Z77+9X1gzc++/vV1077+9VO+/ve+/ve+/ve+/vVBpaO+/vX3vv70cyoLvv73vv71vNijvv73vv71PemRCU2Xvv73vv73vv73vv70de0Ii77+977+977+977+977+9Su+/vdekKe+/ve+/vRbvv73vv73Hhu+/vVPvv73vv70Y77+90ZYSfTFv77+9MVvvv71x77+977+9cO+/ve+/ve+/vc+eeu+/ve+/ve+/vT4j3rPvv71I77+977+977+977+977+977+9CxYu77+9ae+/vSHvv70L77+977+9e0dA77+977+9dO+/ve+/vVZt77+9cu+/ve+/vTxnKHbeglHvv73vv706dO+/vdCm77+977+977+9Xe+/vR0bXCB+77+977+9e++/ve+/vUlL77+977+9J++/vRjvv71P77+9de+/vdqH77+977+9Hu+/ve+/veOxlu+/ve+/ve+/vde0eu+/ve+/ve+/ve+/ve+/vSFu77+9Uu+/vRYj77+9Dyt3bnrvv73vv71H77+9VC9h77+9K++/ve+/ve+/vVweau+/vSXvv70i77+977+9e1p777+9eCvvv71v77+9axnvv73vv73vv73vv70L77+9bu+/ve+/vX/mn4Xvv73vv70477+977+9eO+/ve+/ve+/ve+/vXpGFVLvv73vv73vv73vv71Xfe+/ve+/ve+/vU/vv70E77+9We+/ve+/vVvvv71D77+977+9be+/ve+/ve+/ve+/ve+/vRXvv73vv71JUO+/vTA9Mu+/vVHvv73vv70l77+9Se+/vWZ077+977+9Vu+/ve+/ve+/ve+/vWZBee+/ve+/ve+/vRHvv70kMu+/vVEWGW0a77+977+9LD1R77+9Ue+/vXrvv71kIu+/vSfvv70TaEbvv70cx7fvv73VqnTvv71idu+/ve+/ve+/ve+/vVXvv71977+9Tu+/ve+/ve+/vXfvv73vv71zfRnvv73vv73vv71t77+9f3Dvv73vv71D77+9De+/vTjvv73vv73vv71h77+977+977+9Ww8c77+977+9MGzvv70x77+9D2w/eGDbge+/ve+/vQ/vv73vv71t77+977+977+977+9x7B377+977+977+977+9Du+/ve+/vWHvv73vv73vv70ybNu/a++/ve+/vV1b77+977+92rLvv73vv73vv71177+977+977+977+977+9HVvvv71s37xn77+977+9PVt/G++/vWzvv719e9i4a++/ve+/vWHvv73vv70NOzZu2L5hw47vv70y77+937Fu77+977+977+977+977+9ybBm77+977+9NWvvv70kJ29e77+977+9edWa77+9K++/vTfvv71Y77+9ae+/ve+/ve+/ve+/vVZuWCbvv70Y77+9Ye+/ve+/ve+/ve+/ve+/vSYtW++/vWjvv73ahe+/ve+/ve+/vSXvv70XLF7vv73vv73vv71yfu+/ve+/vXgZ77+977+977+9C++/ve+/vSUu77+9W++/vXTvv70MCe+/vWfvv71P77+977+977+9aHrvv73vv71pcxfvv73vv71N77+977+977+9EDU7Ye+/ve+/ve+/vVNmzZsyY++/ve+/vRlx77+9Yu+/vUzvv70+J1zvv73omaFRM0Lvv71iQyLvv73vv73vv70hIjpocu+/ve+/ve+/vVNHTe+/vTpiQu+/ve+/ve+/vRHvv73vv70mDQnvv704OGRC77+9DO+/ve+/vQPGhO+/vQsK77+9Gzjvv73vv70M77+977+977+9GDHvv73bsEDvv73vv73vv73vv70MGe+/vXnvv73vv70PA++/vXYYMMS3d++/ve+/ve+/ve+/vWrvv73vv73vv709347vv71977+977+977+977+977+977+977+9YV3vv70P77+9d++/vdKgY++/vQY+fu+/ve+/ve+/ve+/vVrvv71B77+9d2oXa++/ve+/ve+/vV7vv70eDQt7aNGiPDt377+977+977+9T++/vW/vv70x77+9XO+/ve+/vd6977+9JSTvv703Zu+/vX3vv71b77+916jvv71f77+977+977+9fe+/ve+/ve+/ve+/ve+/ve+/vSFx77+977+9A++/vVZRJD1tVUPvv73vv71I77+9AO+/vVbvv71S77+977+9H3zvv73Vt++/vQPvv71pZe+/vUx977+9XSHvv73vv71vO0Tvv71fU++/vXTvv70y77+9X++/vTXvv71vcELvv73vv70lE++/vS/vv73vv70UMDBf77+977+9b++/vW86e++/vU7biSXvv73vv704Hu+/vT1p77+9O0fvv700O0fPme+/vd+7b++/vTfelG7vv73vv71q77+977+9NXDvv73MhEXvv70m77+977+9Nu+/vTjvv708R18a77+977+924oI77+9DO+/vQ0cR8mI77+9He+/vUvvv73vv70GNu+/ve+/vULvv71877+9Ee+/vUnvv73vv73vv73vv73vv70z77+977+9V++/ve+/vQfvv70HHzQeeu+/vXjvv71h77+977+9R++/vUcfNR5777+9eO+/vXEjb17vv73vv70n77+9fO+/ve+/vQIF77+977+977+9MgoWNAoVMgoXNu+/vRQx77+977+9L++/ve+/ve+/ve+/ve+/ve+/vTdefO+/vSha77+9KFbvv70oUe+/ve+/ve+/vX/vv73vv70l77+90qUNLy/vv71MGe+/vWxZ77+977+9V++/ve+/ve+/ve+/vQoV77+977+9Fe+/vUrvv73vv70qVe+/ve+/vV8377+9VTNq77+9MGrvv70077+9fNOoVe+/vXjvv71t77+9dm3vv73vv71377+977+9de+/vXrvv73vv70GDe+/vUbvv73vv73Gje+/vSZN77+977+9Te+/ve+/vc2N77+9LQ1vb++/vXVr77+977+977+977+977+9be+/ve+/ve+/vQ0fH++/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/vTfvv712Ne+/vXc3eu+/vTR677+9Mu+/vU3vv71977+977+9y5zvv73vv70D77+977+9AGPvv71gQ17vv704bO+/vTFi77+9MXLvv70RGGjvv70ebe+/vTvvv73vv73vv73vv701Q0Zo77+9ERZm77+9H2/vv73vv73vv71+IyLCiO+/vTTvv71ONe+/ve+/ve+/vd+efmvvv73vv70aM2ca77+9Zxtz77+9GO+/vVFy77+977+9GwsWyLNY77+9Re+/ve+/ve+/vSRD77+9y7Js77+977+9fO+/ve+/vXLvv73vv71q77+977+977+9bO+/vU3vv73vv73vv70ZGzYYGzca77+9Nxtb77+9GnLvv73Qjh3vv73One+/ve+/ve+/ve+/vd69xr5977+9dO+/vT1077+9OHzvv704elTvv73vv70YKSnvv73vv71lOXlSWlDvv70zZ++/vXPvv73vv73vv73njYsX77+9y5dFR++/ve+/vVfvv71r14wbN++/ve+/vT8277+977+977+977+9z4zvv70/N++/ve+/ve+/ve+/ve+/vSvvv73Wre+/ve+/ve+/ve+/ve+/ve+/ve+/ve+/vRs/77+9aO+/ve+/ve+/ve+/ve+/vS/Gr++/vQrGv2Tvv70s77+9Sjbvv73vv70877+9VkXvv71077+9LdW077+977+9Sinvv73vv712ATZ6du+/vQTvv73vv70DR1AW77+9NBXvv70wJO+/vTl+77+9fnMYGjYtb++/vX/vv73vv73vv71977+977+9bnYxMW5hcO+/vWrvv71fKu+/ve+/ve+/vRU777+977+9JSE577+977+9Yu+/ve+/ve+/ve+/vVtF77+9XO+/ve+/ve+/vSDvv71377+977+977+93q0r77+977+9eu+/vTfvv71777+977+977+9HS8K4oS877+977+9Pe+/vSgiKzLvv73vv73vv73oi5Pvv73vv70p77+9BO+/ve+/vRnvv71V77+977+977+977+9Iu+/vV9HJnbvv71V77+977+977+9DRpM77+9Fu+/vXrvv70uWlncoe+/vWXvv71Q77+9Ae+/vT/vv70/yKfvgLbvv73vv73Sq++/ve+/vT3vv73vv73vv73vv71r77+977+977+9Pe+/vXXvv71v77+977+977+977+9Zi3vv73UqVfvv73vv73vv70vNmrvv73vv71777+977+977+977+9Hu+/ve+/vX8g77+9Vu+/vXbvv73vv73arO+/vX3vv73vv70977+9Vhbvv70wVO+/ve+/ve+/ve+/ve+/vTnvv71j77+9du+/vW3vv73vv71K77+9Xu+/vWHvv73vv71t77+9J2/vv71877+977+977+96rWI77+977+9eO+/ve+/ve+/vVZIU++/ve+/vRFfGRzvv73vv702Gmzvv71jF++/ve+/vU/vv70y77+9W++/ve+/vSzvv70877+9e++/vWQ5GyFyTUceCxEwIu+/vV7vv73vv73vv71a77+9a1Xvv73vv71177+9OjEmdu+/vT5nfR3vv71be0RQVO+/vVnVlxBH77+9FwEp77+9Ju+/ve+/vQTvv73vv70vS++/ve+/ve+/vQXvv715ZnZi77+977+9CMm277+9FwUmTysE77+977+9INu+LD5+NXvvv718Ie+/ve+/vSzduj/avO+/vTN177+9V2zcvGXvv71efUYG77+977+9We+/vXjvv73vv73vv73vv73vv70e77+977+9U0/vv73bl++/vVwT77+9Mu+/vXVe77+977+9LO+/ve+/vRhSPVrvv71I77+9Wknvv73vv71mBT5T77+977+9S1bvv71Z77+9fu+/ve+/vX3vv71QFs+UFRXvv73vv70V77+9XA/vv73vv70V77+9aO+/ve+/vRoYP++/ve+/ve+/vXtU77+9xrQWyYFWFivvv70AN++/vTfvv70jRO+/vSzvv73vv71mw4jvv73vv70mLVvJmwXvv73vv71sG++/vQ7vv70mR++/ve+/vSTvv73vv71FIu+/ve+/vXRA77+9bigy77+9chR577+9Cu+/vWbvv70t77+94pKWFCnvv73vv73vv70777+977+9Fu+/vS3vv73vv73vv71n77+9EHVI77+9Te+/vTbvv70kGHLvv71A77+977+9VVNiZ++/vQwO77+93KPvv73vv70K77+9wrvvv71/77+977+977+977+9FO+/vT3vv73vv73vv73vv70eOn3vv70vcmFo77+977+9B++/vRY/Ejzvv73vv70uXe+/ve+/vWhZ77+9bu+/vXfvv71377+977+9d++/ve+/ve+/vcmRcUnvv73vv71iL9+wddmGLfOWrIjvv70zT37vv71u77+977+977+977+9eO+/ve6OoUpN77+9SVNK77+9MeiAhe+/vWzvv70x77+9dkxjc++/vW3vv700Ju+/ve+/ve+/ve+/vTx0ZO+/ve+/vXXvv71QFk/vv73vv73vv70py5p977+9a++/ve+/vRkRVu+/ve+/vSvvv73Xg2zvv71D77+977+9eTdv3bHvv73Mogbvv70l77+9Ku+/vRxZ77+9bWXvv73vv70RIi0f77+9FjJ277+9ZO+/vXY+cu+xvFnvv71577+9Nu+/vSHvv73vv73vv70TJ28W77+977+977+9SO+/vVHvv71/OMqeLQfvv73vv70YJ3cD77+9CO+/vdyz77+9N++/vdSy77+9XO+/ve+/ve+/ve+/ve+/vSzvv73vv718RVrXnO+/ve+/ve+/vT1g77+9c03vv73vv73vv73vv73vv73vv70s77+9Nj1y77+977+9fXfvv71cFu+/vUnvv73yq7ylXO+/vR/vv71777+977+9K3Tvv73vv711YjDvv73Ksu+/ve+/vVF577+9dO+/vXIv77+9Pu+/ve+/vVrvv73vv71ySUjvv71O77+977+9HUPvv70R77+977+9G2nvv70277+977+977+9e3nvv70p77+9cu+/vUZRFi4M77+9CmXvv73vv71m77+9DO+/vVbvv73vv70r77+977+977+977+9OO+/vRkaPe+/ve+/vUteai7vv71EWe+/ve+/ve+/ve+/ve+/vcuS77+977+977+9CO+/vWPvv73vv73vv70xct+jPO+/vU3vv70s2LBp77+9Ie+/vWMSV++/ve+/vSfvv71l77+977+977+977+9cu+/ve+/vQXvv73vv71Sbl3vv71j77+977+9P1nvv70N77+9UU/vv73vv71OWl8yyo3vv70uJyDvv71O77+9LO+/ve+/ve+/ve+/vW9D77+977+977+9Je+/vdCI77+9SlkkSFxeSDLvv70lIO+/vVzvv73vv73vv71v77+9di/XoXMDJ0/vv701BUU1du+/ve+/ve+/vWXvv70zCtW9Xe6alnvvv71l77+977+9aR9JQu+/vUbvv709de+/ve+/ve+/vX/vv73vv73vv73Mp++/ve+/vSUh77+9dULvv73vv71j77+9HGnvv73vv70ofO+/vXDvv70kNDV277+9Uu+/ve+/ve+/vU/vv73vv73vv73DrcWs77+9Hn/vv73vv71xC0IcBe+/vXHMuO+/ve+/vQfvv73vv71BWWx3fg9O77+9JEIiYmfvv70aOO+/ve+/vW4977+9VO+/vSHvv71ma++/vW/vv71v77+9cGk077+9J++/vTtBZ3bvv73vv73vv73vv71J77+977+977+9YXLvv73vv73vv71577+9KE7vv73vv73vv71PHXrvv71X77+9V++/ve+/ve+/ve+/ve+/vTFN27Tvv73TsO+/ve+/vRV5M++/ve+/vTbvv70cXEdNF30i77+977+977+977+977+9LnzHkO+/ve+/vUjvv73vv70I77+977+977+9NO+/ve+/vdu3XXZbO2VJ77+9dO+/vW7vv73vv73vv70dQ+qSkHpz77+9Cu+/vTrvv73vv71j77+977+977+9De+/ve+/vUUG77+9NiJv77+9Vu+/ve+/vTRd77+9bu+/vSjvv73vv71N27jvv73vv73vv719RXY/77+9Qu+/ve+/ve+/vSXvv70yc3AJXzLvv73vv71L77+977+977+9WO+/ve+/vQzvv73vv73vv73vv73vv70I77+977+977+9Su+/ve+/vStf77+977+9d++/ve+/ve+/vRbvv71x77+977+9QV8u64iUSO+/ve+/vTjvv73vv73vv73vv71be0Rr77+9SO+/vWQufnITAu+/ve+/vQXvv70877+977+9NzkH77+9Gu+/vS9/77+977+977+9CUpZ77+9Oe+/vU1WSu+/vWJIS++/vc2b77+977+9QycOcXzvv73vv73vv73vv73vv73vv71PKO+/ve+/vTc577+9Du+/ve+/ve+/ve+/ve+/ve+/vU/vv70fYu+/ve+/ve+/vUjvv73vv73vv71P77+936vvv73vv70q3aTvv73vv73vv70g77+977+977+977+977+977+9P148JO+/ve+/vVXPlXzKi++/ve+/vXvvv73vv73vv70MLFDgqYTvv73vv71KWU7vv73vv73Mo++/vXLvv73vv70k752b77+9V1pZ77+9FkRmSlkS77+9PO+/ve+/ve+/vWUWNUhN77+977+9Mjrvv73blO+/ve+/vQRuK++/vT3vv70QaRzvv73vv707cmYm77+9We+/vdet77+9a03vv73vv73vv70277+9Oxbvv70J3JBAWFTvv70L77+977+9ZO+/vTBiO++/ve+/vUXvv73vv73UqO+/ve+/ve+/vV8dSe+/vVZpSO+/ve+/ve+/vRVB77+9c++/ve+/ve+/ve+/ve+/ve+/ve+/ve+/vRDvv73vv70QET1i77+977+9VhHvv70177+9xZbvv73vv73Pt2jvv73vv73vv71c77+977+977+977+9Z++/vX5+77+977+9Cu+/ve+/vWrvv70O77+9CQodGzFt77+977+9RUvvv73CkFwe77+9W1ZG77+977+977+9fu+/ve+/ve+/vWLvv70qS8qla++/vQYPeO+/ve+/ve+/vWIh77+9bw5K77+9HUMqZu+/vUxu77+9Glrvv73vv71R079777+9FWs377+977+9bNqx77+9B++/vXvvv73vv71I77+977+9Fe+/vWvvv73vv73vv71w77+977+977+9dO+/ve+/vR8877+9dO+/ve+/vVAW77+977+977+9U++/ve+/vTZC77+9aCjvv71577+9du+/ve+/ve+/vScp77+9Iu+/vSLvv70iJ2rvv70u77+9CjDvv73vv73vv71X77+977+977+977+91bU177+9O++/vQPvv70HSjNtXO+/vVLvv70s0o0677+9Qe+/ve+/ve+/ve+/ve+/ve+/vUs977+9ee+/ve+/vRUbNu+/vS9aEBU7ZHJk77+9yKg3Y++/vRXvv705K++/vXrvv73cnO+/vSdiZ++/vTsy77+977+977+9Ce+/ve+/vSbvv71P77+9GjFj77+9AhHvv70t77+9Du+/ve+/ve+/ve+/ve+/vSUK77+92IJidkBxYQNnRsqScu+/vWrvv71X77+9Su+/ve+/ve+/vUfvv73Ive+/ve+/ve+/vSDvv713DHXvv73vv73vv70MJHnvv73vv71z1Z8tWu+/ve+/ve+/vVVr77+977+977+9Wu+/vVzvv70rEu+/vVIh77+9Je+/ve+/vWFwaHTvv71/77+9H++/vXjvv73vv70s77+977+9Q18uX9mv77+9EDXvv718Sg7vv71A77+977+977+977+977+9fO+/ve+/vXBh77+9SO+/vVl5De+/ve+/vT0H77+977+977+9XETvv707dO+/ve+/vTMI77+93rrvv73vv70z77+977+977+977+9bFYw77+9E++/vUkBRe+/vXtO77+9BmweRjzvv73vv71L77+977+977+977+9O++/ve+/vW3vv707bu+/ve+/vVrvv700PnbOsO+/ve+/ve+/ve+/vUzvv70WGVU0Ou+/ve+/vd+efu+/vUDMtAJRMWUj77+93pAb77+9I++/vQ3vv70eN3vvv73vv73vv73vv73vv707dx5JEe+/ve+/vSvvv70I77+977+9W+2OpO+/ve+/vT/vv70OKO+/vUJQ77+977+977+9AUTvv705Ue+/vWXvv70377+977+9YF4zZu+/ve+/ve+/vSrvv70oYi3vv73vv70Y77+977+9YSXvv70q77+9YmlYXO+/ve+/ve+/vX9+bO+/ve+/vRVrNu+/ve+/ve+/vT50VO+/vVjvv73vv73vv73vv73vv71i77+977+9f++/ve+/vSPvv73vv73aje+/ve+/vVDvv71M77+9Hu+/ve+/ve+/vRrvv71677+9Gu+/vW7vv73cq3zvv73vv70LAzM677+9BC8a77+977+9a0Dvv70CT0cvXG/vv70lOe+/vWPvv73Hs8qdK0jvv73vv73vv73vv71uZe+/vRt7N++/ve+/vey1jA4jdu+/vX17du+/vVzvv73vv70677+9JCxf77+977+9XVbvv70aD++/vTrvv73vv73vv73vv71177+9dy9e77+9cO+/ve+/ve+/vVHvv718J095c++/ve+/vRITJjzvv73vv70D77+9H++/vRLvv71077+977+9V++/vUTVi++/ve+/ve+/vTYrJGFJ0ooNWzbvv705cO+/ve+/ve+/vUwK77+977+9Hu+/vVY2ekbvv73vv73vv73vv71EWe+/vV/vv73asO+/vXsqZjrvv71v77+977+977+9OO+/vWPvv719cBMVPO+/vXp377+9Vu+/ve+/ve+/ve+/ve+/ve+/vSzvv702bO+/ve+/ve+/ve+/vShLbmpl77+9Q1nvv71J77+90oLvv71C77+977+977+977+977+9dO+/vUIU77+9FCLvv73vv73vv70j77+977+9Hz3vv73vv70VSe+/vSwZ77+977+977+9Me+/vVZZ77+9EO+/vdim77+9ei3vv73an1lRZSYRETtTKe+/vdSm77+977+9bO6Tv++/vRJ177+9zIU977+9T27vv71zQF7vv704e15gZHTvv73vv73vv71r77+977+9FQ0KekDvv70xNG7vv70DYe+/ve+/vSZFVO+/vRLvv704Ou+/vX9u4pSla++/ve+/ve+/ve+/vS3vv70nR++/vV92XBHvv70977+977+9Kl1ibVtQ77+9WVAcS2UG77+9c2Xvv715ONWcMjPvv73YuHjvv70s77+9Uk9/77+977+977+9KEtuVBbvv70P77+977+9Gnl/77+977+9Y++/ve+/ve+/veK9gO+/ve+/ve+/vS0IDV88ISxxyoDvv73vv71S77+9Xu+/ve+/ve+/ve+/vSPvv73vv73vv70K77+94riLeu+/vRg5fO+/vW5xIu+/vcO277+977+9Wx3vv73vv70W77+93ahcJDPvv71J77+977+977+977+9He+/ve+/vTw577+977+977+977+9eO+/ve+/ve+/ve+/vTsOHu+/ve+/vTjvv71dMG5K77+9B++/vRNqBe+/vSk+ZGgeeS3vv73vv70Ree+/vUPvv73vv73vv71ExrTvv70VPyJhSe+/vcqNG++/ve+/vWRvyqljF++/vXkV77+9KSjvv70l77+9cu+/vUcS77+9Fu+/vXTvv70xzqnvv70377+9w7nvv70cO++/vXbvv73vv73vv70jZy8lLF01c++/vcKZ77+9Emfvv71L77+977+977+9X9KK77+977+9K++/vSxZ77+9Vjrvv70sXe+/vW5p77+977+9Ze+/ve+/vURZ77+9be+/vXHvv73Lr1Hvv70ROe+/vXXvv71/77+9Ek9zVu+/ve+/vRvvv70W77+9b9elX++/vVJl77+977+9KzLvv71Df++/ve+/ve+/ve+/vU/vv73vv70y77+9bkrvv70qE++/ve+/vVHvv70X77+9JWYDASIkGyB777+9Iu+/ve+/vW7vv73vv73vv73vv73vv71qZe+/vXvvv70877+977+977+977+977+977+9HDh5dseB77+9K++/vSfNjB8xJe+/veO4sHfvv73vv70s0adPHnnvv71z77+977+9eQLvv73vv73vv73vv71ExrTvv70zP0haWTbvv73ev++/vUjvv71cGO+/ve+/vWjvv704SB9Y77+9GFlpMu+/vS7vv71yR++/ve+/ve+/ve+/ve+/ve+/vTQzDDLvv70sR++/vV3vv715KCXvv73vv71y77+9Qu+/vSfvv73vv71DWXLvv73vv73vv73vv70977+977+9IBHvv73vv73vv70dYjzvv73vv71sXyvvv70h77+9EiHvv70UD3dc77+9U++/vT7vv71a77+9Qu+/ve+/ve+/vTTvv71S77+9bu+/ve+/vXfvv73vv71tJ++/ve+/vVgE77+977+977+9y4fvv70q77+90aPvv703Lu+/vRU/elLvv71f77+977+9Wn3vv73vv73vv73vv70/T++/ve+/vUbvv70+Tw4d77+9H1Hvv73vv70Y77+977+977+977+977+9yrLvv73vv71haT7vv70LQ++/ve+/ve+/vTnvv71j77+977+977+9OG7vv73vv71V77+977+9Zy8fOXPvv73Ime+/ve+/vU9f77+977+977+977+977+9T29e77+977+977+9a++/vd+677+977+977+9G198fe+/ve+/vW8+77+977+977+977+9N++/ve+/ve+/ve+/ve+/vVDvv73bvXAd77+9e++/vRgqJE/dsu+/vVovIu+/vVUkc0k+Ue+/ve+/ve+/vVHvv70J77+977+9D++/vc6277+9X++/vWXvv73vv70iaDnvv73Rgu+/vW/vv71y77+977+9xbQjZy/vv71PSV3vv73vv70wI25U77+9BO+/ve+/ve+/ve+/ve+/vXZ777+977+9J0/vv73vv71GF++/vScHDSk7Lu+/vVHMjH7vv73Lou+/vW/fsO+/vdiJAyfvv71I77+977+977+9I33vv71u4ZGnPO+/ve+/vUhnFO+/vQ9BcR/vv70o77+9Pe+/vV8p77+977+9Me+/vTnvv73vv73vv73vv71uWBLvv73vv70NN++/ve+/vRbvv714Wu+/vTxK77+9bu+/ve+/ve+/vTfvv73Fi8WK77+9PO+/vXZP77+977+9LShp77+9Nu+/vWvvv70vXO+/vX5g77+977+9VXPvv71nDhsV1LxP77+9Kj4fFGrvv73vv71o77+977+977+977+9Ye+/vQEB77+977+9Ju+/ve+/ve+/vRHvv71w77+977+9Te+/ve+/vR48eVbvv73vv73vv73FqzLvv73dlu+/ve+/ve+/vSJ277+9Lu+/vXjvv73vv73Yre+/vXw177+9Jd2EXAXvv73vv73vv73vv70dQ++/vS/vv71cGO+/vUIrS++/vTnvv70j77+977+9Me+/vXjvv73vv71XWe+/vU3vv73vv70EF++/vRx3VO+/vRnvv73lqLDvv73vv70I77+977+9eHDvv70i77+9RnZ577+9ZGHHpu+/vTvvv70pX++/ve+/vU7vv71777+9bO+/vVsx77+977+9aTdOXO+/ve+/vXrvv73vv73vv71977+9HO+/vVnvv70j77+9Dh3Vsu+/vX/vv71m77+977+91a1rNGrvv73vv73vv73vv71z77+977+977+9Dhnvv70bGxfvv71sTcK+77+9KUfvv71c77+977+977+9cn3vv71OUO+/vTrvv73vv73vv73vv71nJ++/vUNQPO+/vQXvv715MO+/vV9t77+9A++/vWnvv70l77+977+977+9S++/vcWMOVXvv71Y77+9NO+/vSLvv73vv70E77+977+9Bu+/ve+/ve+/vSFh77+9Uu+/vVIO77+9K++/vTdr77+9GO+/vRnvv702X++/ve+/ve+/ve+/vUHvv70877+977+9VzEMeVDvv71J77+9J3vvv73vv73vv71dW2bvv71H77+9De+/vdGzT++/ve+/vT4v77+977+91oM1axrvv71rP++/ve+/ve+/ve+/ve+/vQPvv73vv71M77+9Onte77+977+9He+/vQ7vv708Le+/vS1iJ++/vQQU77+977+9InZiCu+/vc6jJ++/ve+/ve+/vS5877+977+977+9Y3Ivcnbvv70U77+9MSgLypLvv73bs++/ve+/ve+/ve+/ve+/ve+/vUl5EiHvv73vv70177+9xbrvv71r77+9du+/ve+/vWXvv73YoO+/ve+/vQTvv71b1azTsO+/ve+/ve+/ve+/vUUERe+/ve+/ve+/vS/vv71Y77+9Impm77+977+977+9Lu+/vT3vv703aO+/vULvv70qD1bvv71o77+9Uzvvv73vv73vv71rAUNb77+9Te+/ve+/vWDvv70saWVJ77+977+9Ju+/ve+/vU5c77+977+9aBt2PWTvv73vv73vv70M77+977+9Y3wv77+977+977+977+977+9RixxxLTvv73vv70tTe+/ve+/ve+/ve+/vcmb77+9Xe+/vSzvv73vv70x77+977+9D++/ve+/ve+/ve+/ve+/vVkWAu+/ve+/vTHvv73vv73vv73vv70V77+977+9FgIQcCsCce+/vQnvv73vv717bO+/ve+/vQ4ZGe+/vR3vv71L77+93YLvv70LTu+/ve+/ve+/ve+/ve+/ve+/vX4k77+9Pt6XenLvv73vv71V77+977+9E++/vQ3vv71r77+977+977+9GjUL77+9Lm14eRlv77+9Xe+/ve+/vW/vv71+Ae+/vSNi77+977+9Vi/vv7115JCo77+91KPvv70177+92L8277+9TlDvv73vv71E77+977+977+977+9Q1Bc77+977+9ehbvv71777+9Lx1lce+/vQbvv70s77+9JEzvv70HMe+/vUIAAh5AIDXvv71a77+9aiXvv71377+9eUcvcT7vv71377+9ei95ee+/ve+/vWsR77+977+9Vu+/ve+/ve+/ve+/vTNn77+9Vu+/vRg3Me+/vWfvv70O77+9bd6pWO+/vXDvv71i77+9Fy9xf++/vWrvv73vv73vv73vv70zcGjvv73vv71pIe+/vdetOHbvv73vv70p77+977+9c1UGezvvv71tYe+/ve+/vUDvv71beO+/vdmy77+977+9Ee+/vQPvv73vv73vv70q77+9LCgL77+9AQEIQCDvv70JBEbvv70q77+977+9U3Lvv73vv71zI++/vcyvJe+/vRQfNHLvv71dTxHvv73vv71QOe+/ve+/vWPvv73vv73vv70XBe+/ve+/ve+/vdG3c++/vUY1S3sVLFTvv73vv71377+9R++/ve+/vSjvv73Mu1bvv73vv73vv73vv73vv73Tk++/vW48eO+/ve+/vTTvv73vv71277+9eUfvv71pe++/ve+/ve+/vV0s77+9Im8XN18TKO+/ve+/vS3vv73vv71ZJu+/ve+/ve+/vSw5f++/ve+/vXLvv70yIwQg77+9GQTvv73vv70977+977+977+977+9fUbvv73vv70ZI++/ve+/vTRdx79f77+9cO+/vU17D++/ve+/vRFH77+9dSx177+977+9ZQPvv70Obu+/vde277+9G++/ve+/vX8hf968Ru+/vQLvv71X77+9We+/ve+/vW/vv73vv73vv73vv73vv73OjN6wa1fKpe+/ve+/ve+/vSQ9RzHvv70xdnwLT27vv70ha++/ve+/vd6lURbvv70FZe+/vQAEIO+/ve+/vQTvv73vv71qVe+/vUrvv70777+9SO+/vSfvv71a77+9Yu+/vUZNImfvv70JGDnKu23vv71KVSvvv73vv73vv73vv73vv70eMgo877+977+977+9VSs077+9bjJ8zKjZiQlb77+9H++/ve+/vX0y77+9Yu+/vQPvv716yL3vv712R++/ve+/ve+/vR7vv70Z77+9yp7vv70oC8qSw4fvv73vv70JdO+/vQIBCO+/vTMB77+9Z++/vTfvv71p77+977+977+977+9U++/vQjvv70keT7vv73vv73vv71K77+977+977+977+9Bx/vv70aFzJjfu+/ve+/ve+/ve+/ve+/ve+/ve+/vTTvv73vv73vv71CdkBUD++/ve+/ve+/vU/vv73vv70WHu+/vXpN77+9Xe+/vXPvv71X77+9BWVBWSAAAQjvv70w77+9IWNGe1UtcUcR77+977+9BCMT77+977+9Ve+/ve+/ve+/ve+/vVvvv71f77+977+977+977+9dO+/vWAsde+/ve+/vQFFOu+/vUjvv70TeQXvv73Zgu+/vTfvv700PWTvv71T77+9UBbvv70l77+9D1Xvv73vv71jUCoIQCA7Cci977+977+977+9IFfvv71lCe+/vT7vv73vv70z77+977+9Tkzvv73vv70ASX9YWRHvv70BRe+/vRgrHVBk77+977+977+9G++/ve+/vd+sHu+/vSLvv70iLShSF2bvv73vv73vv73vv73vv70RQFlQFu+/vQUCEO+/vUDvv70T77+9S1pS77+977+9M++/ve+/vRgKWtS377+977+9V++/vUFD77+9cwvvv73vv73vv73vv73vv71sP3Rc77+9Y++/ve+/vWTvv70Ycnwu77+9BWXvv73vv71DVe+/ve+/vQYUAAIQcAcCb9SpZe+/ve+/vSxdB3crWe+/vUvvv73vv73vv70LQ+6wvu+/ve+/vW4J77+9LCgL77+9AgEIQO+/vS0ISO+/ve+/vScL77+977+977+977+925Dvv71hckkoNGLvv71S77+977+977+977+977+9be+/ve+/ve+/ve+/vUwAZUFZ77+977+9UO+/ve+/vTsJZe+/vQAE77+977+9QO+/vR7vv73vv73vv73vv73vv71kN1vvv73Jmu+/vWlR77+9YSPvv70rC1YkSxfvv71sKzkL77+9BgIoC8qC77+9QAACEHAXAu+/vU/vv71g77+977+977+977+9Ju+/ve+/vVnvv73vv73vv70vMD0+QSnvv71077+9zYZK77+9RWQnAe+/vQVlce+/vUNVdu+/vT3LggAE3JZAWFTvv70L77+977+9OO+/ve+/vTgfM3pR77+9KjXvv73vv71177+9V++/vSJ3LEvvv73vv73vv73vv71I77+977+9RgBlQVlQFghAAALvv71F77+977+977+977+977+977+977+9OncU77+9XwPvv70H77+9WO+/vVhc77+9Uu+/vSx377+9WsSs1aDMle+/vQRQFu+/vcW9DlXZvAPvv704CEDvv70NCe+/vd6677+977+9M++/ve+/ve+/ve+/vWzvv70lGX0NTgoo77+977+9c8OC77+977+977+977+9A1fvv71w77+9KO+/vXUCKAvKgu+/vUAAAhBwOwLvv73vv73vv73vv71s77+9Wkbvv71iN963Z++/ve+/vdWqK19JWO+/ve+/vWfvv71a77+9A++/ve+/vQFlQVnvv73vv71Q5Z67Cu+/ve+/vQAE77+977+977+977+9U++/ve+/vSVB77+977+977+977+977+977+977+9Re+/vRDvv73vv73vv71kWe+/vUkAZUFZUBYIQAACbkpA77+9KHnvv73vv71y77+977+9fMqr77+9Tu+/vX3vv73vv73vv70o77+977+9TgIoC++/veKmh++/ve+/ve+/vQ1YFgQg77+977+9BO+/vSNtZmRFTe+/vSfvv73vv73brggF77+9TgBlQVlQFghAAAIQ77+977+9BgRQFu+/vUXvv70w77+977+977+977+9AAEIQAAC77+9E0BZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEx1PzPvv73vv70Q77+9AAQgYO+/vQDKgu+/ve+/vSwQ77+9AAQgAAENCO+/vSwo77+9BmFq77+977+977+9AQIQ77+9AAR0J++/ve+/ve+/vSwoCwQgAAEIQEADAigLyqJB77+977+9fmZA77+9IQABCEDvv706Ae+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdS677+977+9AwQgAAEI77+9TgBlQVlQFghAAAIQ77+977+9BgRQFu+/vUXvv70w77+977+9zIDvv71DAAIQ77+977+9dQIoC8qC77+9QAACEO+/vQAENCDvv73vv73vv70sGu+/ve+/vXU3JwcIQAACENCdAMqC77+977+9LBDvv70ABCAAAQ0I77+9LCjvv70GYe+/ve+/ve+/vQHvv73vv70ABCAAAe+/vQRQFu+/vQVl77+9AAQgAAEIaEAAZUFZNAhT77+9bk4OEO+/vQAEIO+/vTsB77+9BWVBWSAAAQhAAAIaEEBZUBYN77+9VO+/vTMD77+9DwEIQAAC77+9Ce+/vSwoC++/vQIBCEAAAhDQgADKgu+/vWgQ77+977+93ZwcIAABCEBAdwIoC8qC77+9QAACEO+/vQAENCDvv73vv73vv70sGu+/ve+/ve+/vWcG77+9HwIQ77+9AATvv70TQFlQFu+/vQUCEO+/vQAEIO+/vQEB77+9BWXvv70gTO+/ve+/vTk5QAACEO+/ve+/ve+/vQRQFu+/vQVl77+9AAQgAAEIaEAAZUFZNAhT77+977+9DCg/BCAAAQhYJ++/ve+/ve+/vSwoCwQgAAEIQEADAigLyqJB77+9Wndzcu+/vQAEIAAB77+9Ce+/vSwoC++/vQIBCEAAAhDQgADKgu+/vWgQ77+977+977+9GVB+CEAAAhDvv71OAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv73vv73vv73vv70AAQhAAALvv70TQFlQFu+/vQUCEO+/vQAEIO+/vQEB77+9BWXvv70gTHU/M++/ve+/vRDvv70ABCBg77+9AMqC77+977+9LBDvv70ABCAAAQ0I77+9LCjvv70GYWrvv73vv73vv70BAhDvv70ABHQn77+977+977+9LCgLBCAAAQhAQAMCKAvKokHvv73vv71+ZkDvv70hAAEIQO+/vToB77+9BWVBWSAAAQhAAAIaEEBZUBYN77+91Lrvv73vv70DBCAAAQjvv71OAGVBWVAWCEAAAhDvv73vv70GBFAW77+9Re+/vTDvv73vv73MgO+/vUMAAhDvv73vv711AigLyoLvv71AAAIQ77+9AAQ0IO+/ve+/ve+/vSwa77+977+9dTcnBwhAAAIQ0J0AyoLvv73vv70sEO+/vQAEIAABDQjvv70sKO+/vQZh77+977+977+9Ae+/ve+/vQAEIAAB77+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv71uTg4Q77+9AAQg77+9OwHvv70FZUFZIAABCEAAAhoQQFlQFg3vv71U77+9MwPvv70PAQhAAALvv70J77+9LCgL77+9AgEIQAACENCAAMqC77+9aBDvv73vv73dnBwgAAEIQEB3AigLyoLvv71AAAIQ77+9AAQ0IO+/ve+/ve+/vSwa77+977+977+9Zwbvv70fAhDvv70ABO+/vRNAWVAW77+9BQIQ77+9AAQg77+9AQHvv70FZe+/vSBM77+977+9OTlAAAIQ77+977+977+9BFAW77+9BWXvv70ABCAAAQhoQABlQVk0CFPvv73vv70MKD8EIAABCFgn77+977+977+9LCgLBCAAAQhAQAMCKAvKokHvv71ad3Ny77+9AAQgAAHvv70J77+9LCgL77+9AgEIQAACENCAAMqC77+9aBDvv73vv73vv70ZUH4IQAACEO+/vU4AZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/ve+/ve+/vQABCEAAAu+/vRNAWVAW77+9BQIQ77+9AAQg77+9AQHvv70FZe+/vSBMdT8z77+977+9EO+/vQAEIGDvv70AyoLvv73vv70sEO+/vQAEIAABDQjvv70sKO+/vQZhau+/ve+/ve+/vQECEO+/vQAEdCfvv73vv73vv70sKAsEIAABCEBAAwIoC8qiQe+/ve+/vX5mQO+/vSEAAQhA77+9OgHvv70FZUFZIAABCEAAAhoQQFlQFg3vv73Uuu+/ve+/vQMEIAABCO+/vU4AZUFZUBYIQAACEO+/ve+/vQYEUBbvv71F77+9MO+/ve+/vcyA77+9QwACEO+/ve+/vXUCKAvKgu+/vUAAAhDvv70ABDQg77+977+977+9LBrvv73vv711NycHCEAAAhDQnQDKgu+/ve+/vSwQ77+9AAQgAAENCO+/vSwo77+9BmHvv73vv73vv70B77+977+9AAQgAAHvv70EUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIU++/vW5ODhDvv70ABCDvv707Ae+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vVTvv70zA++/vQ8BCEAAAu+/vQnvv70sKAvvv70CAQhAAAIQ0IAAyoLvv71oEO+/ve+/vd2cHCAAAQhAQHcCKAvKgu+/vUAAAhDvv70ABDQg77+977+977+9LBrvv73vv73vv71nBu+/vR8CEO+/vQAE77+9E0BZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEzvv73vv705OUAAAhDvv73vv73vv70EUBbvv70FZe+/vQAEIAABCGhAAGVBWTQIU++/ve+/vQwoPwQgAAEIWCfvv73vv73vv70sKAsEIAABCEBAAwIoC8qiQe+/vVp3c3Lvv70ABCAAAe+/vQnvv70sKAvvv70CAQhAAAIQ0IAAyoLvv71oEO+/ve+/ve+/vRlQfghAAAIQ77+9TgBlQVlQFghAAAIQ77+977+9BgRQFu+/vUXvv70w77+977+977+977+9AAEIQAAC77+9E0BZUBbvv70FAhDvv70ABCDvv70BAe+/vQVl77+9IEx1PzPvv73vv70Q77+9AAQgYO+/vQDKgu+/ve+/vSwQ77+9AAQgAAENCO+/vSwo77+9BmFq77+977+977+9AQIQ77+9AAR0J++/ve+/ve+/vSwoCwQgAAEIQEADAigLyqJB77+977+9fmZA77+9IQABCEDvv706Ae+/vQVlQVkgAAEIQAACGhBAWVAWDe+/vdS677+977+9AwQgAAEI77+9TgBlQVlQFghAAAIQ77+977+9BgRQFu+/vUXvv70w77+977+9zIDvv71DAAIQ77+977+9dQIoC8qC77+9QAACEO+/vQAENCDvv73vv73vv70sGu+/ve+/vXU3JwcIQAACENCdAMqC77+977+9LBDvv70ABCAAAQ0I77+9LCjvv70GYe+/ve+/ve+/vQHvv73vv70ABCAAAe+/vQRQFu+/vQVl77+9AAQgAAEIaEAAZUFZNAhT77+9bk4OEO+/vQAEIO+/vTsB77+9BWVBWSAAAQhAAAIaEEBZUBYN77+9VO+/vTMD77+9DwEIQAAC77+9Ce+/vSwoC++/vQIBCEAAAhDQgADKgu+/vWgQ77+977+93ZwcIAABCEBAdwIoC8qC77+9QAACEO+/vQAENCDvv73vv73vv70sGu+/ve+/ve+/vWcG77+9HwIQ77+9AATvv70TQFlQFu+/vQUCEO+/vQAEIO+/vQEB77+9BWXvv70gTO+/ve+/vTk5QAACEO+/ve+/ve+/vQRQFu+/vQVl77+9AAQgAAEIaEAAZUFZNAhT77+977+9DCg/BCAAAQhYJ++/ve+/ve+/vSwoCwQgAAEIQEADAigLyqJB77+9Wndzcu+/vQAEIAAB77+9Ce+/vSwoC++/vQIBCEAAAhDQgADKgu+/vWgQ77+977+977+9GVB+CEAAAhDvv71OAGVBWVAWCEAAAhDvv73vv70GBFDvv71777+9LO+/ve+/vQcBCEAAAhDvv70ABNyS77+9S++/vUbvv71g77+9f25ZQgoFAQhAAAIQ77+9AAR+77+977+977+977+9L3xCAAIQ77+9AAQgAAHvv70k77+9eyvvv717Fu+/vVJBAAIQ77+9AAQgAAFFAGXvv719ee+/vQECEO+/vQAEIAABNyfvv73vv73vv71MSu+/ve+/ve+/vUXvv714EO+/vQAEIAABCHgY77+977+9y7Zm77+9Ru+/vSvvv73vv73vv73vv73vv73vv71oHjXvv712Atu077+977+977+9FQIQ77+9AAQgAAEXEu+/vSpY77+9Pu+/ve+/vXXvv73vv73vv70u77+9Nu+/ve+/ve+/vXXvv73vv71a77+9Ue+/vSlL77+977+977+977+977+9RFnvv73vv73hp5zvv73vv71yIQABCEAAAu+/vUdA77+9bFnvv70K77+977+9bjly77+977+977+9eS5f77+9bO+/ve+/ve+/ve+/ve+/ve+/vTjvv73vv73vv73vv73vv73vv70VNe+/ve+/ve+/ve+/ve+/ve+/ve+/vRpj77+9JRHvv71k77+977+9Xu+/vSkL77+9T++/ve+/vXjvv70zNe+/vXzvv70/c++/vVFzVu+/ve+/ve+/ve+/ve+/ve+/ve+/vQERF++/vX/vv73vv713P++/ve+/vdWU77+9fu+/vWPdgVNs77+9F++/vQxLXO+/vWF477+9TDxn77+9Hu+/vRPvv70Q77+9AAQgAO+/ve+/vUlA77+9S++/ve+/vVJd77+9Se+/vVjvv73vv73vv73vv71277+977+977+9MkhC77+9SO+/vVnvv71nVO+/ve+/ve+/vWXvv73vv71hc0vvv70fKWPUlDImYO+/ve+/ve+/vW9977+9P2Hvv70a77+977+9Fe+/ve+/ve+/ve+/ve+/vXRsa++/ve+/ve+/vTjvv70V77+9Ue+/ve+/ve+/ve+/ve+/vVfvv70nSQgL77+9Ue+/vSbvv73vv71ffyfvv73vv70477+977+977+977+977+977+977+9FXDvv73elXJe77+977+977+9a++/ve+/vWvvv73vv70TS++/ve+/ve+/ve+/ve+/veevqjEy77+977+977+977+977+9dA0R0JFL77+977+9T0p3bO+/vScNAQhAAAIQ77+9VQTvv70qWO+/ve+/ve+/ve+/vX9R77+977+977+977+9Je+/ve+/vWU4cO+/ve+/ve+/ve+/vX7vv71s77+9QVPvv70O77+977+9duGWgzV677+977+9BGpK77+9PSRh77+9be+/ve+/ve+/vRXvv70s77+9yZ/vv73vv73vv71eWRQC77+977+977+9EFIidyYa77+977+9Tynvv73vv70W77+9UO+/vTZnbD1677+9yIp8NSfvv71EWe+/ve+/vWpGM2Hvv71AAgIQ77+9AAQg77+9Cwnvv73vv73vv700Ae+/vRdx77+9Ke+/vTlm77+977+9I3IRQxpdRFY+77+977+9K++/vVLvv71q77+9ce+/vcqc77+9TGRn77+9LQt177+977+9TFnvv73vv73vv70bWmxDQXAoETHvv73Ir++/vWDvv73vv70dI++/ve+/vVPvv73vv71sP++/ve+/vVUTOO+/vSU377+9Uu+/vVfvv71XP++/vUI1Uu+/ve+/vThJ77+977+9SBoCEO+/vQAEIO+/vXsI77+977+9Y++/ve+/vTHvv73vv71cUSvvv71qVe+/vTrvv71rGu+/vcSy77+977+9Se+/vVXvv73vv71Ieu+/ve+/vR1qSnN2M++/ve+/vRXvv70sNO+/vT87X++/ve+/ve+/ve+/ve+/vUXvv70+77+977+9b3fvv71eEAQyy6Dvv73vv71MRu+/vWBBJi1R77+977+977+9TT4rdgk277+9T1pNXu+/vRbvv71+77+977+977+9ae+/ve+/vU0x77+977+977+977+977+9Pu+/vVLvv70T77+977+9Iu+/vUxy77+977+977+977+977+9CTMfEhDvv70ABCAA77+9XEVA1Ynvv712HCMuIu+/vSdq77+977+977+977+977+9FxJnXhjvv706KUEu77+9SAvvv73vv706IGbvv73vv717Ry5SU++/vVvvv73vv71g77+9LeWRv0x177+9VSvvv73vv73vv73vv73vv70HRO+/vV7vv73vv73vv70v77+977+9bu+/ve+/vXfvv73vv70r77+9Se+/vXpIWO+/vWUd77+977+9yIfvv70j77+9y7bLj++/vUY+77+9Y++/ve+/ve+/vSQ577+977+977+9VO+/vWbvv73vv71j77+9dx7vv70u77+9Mu+/ve+/ve+/vTFh77+9QwICEO+/vQAEIO+/ve+/vQhI77+9KH/vv71nRTrvv73vv70rLu+/vQfvv73vv71v77+977+977+9du+/ve+/vX0DZe+/vXId77+977+9ehXvv71RE8u877+977+9HO+/ve+/ve+/vTzvv73vv70r77+977+96bSy77+9H++/vVpU77+977+9Pu+/vTXvv73vv73vv73vv70YAhDvv70ABCAAAQgI77+977+9fEV+77+9UFnvv70GTiQuazMyFwQgAAEIQAACEHBC77+977+977+977+9ZEnvv70EAQhAAAIQ77+9AATvv71MAGXhnYgQ77+9AAQgAAEIaEAAZe+/vWAjZVlI77+9EQIQ77+9AAQg77+9MQTvv70fWHJA77+9BO+/vSXvv70AAAAASUVORO+/vUJg77+9';
		$this->imageMapResult = <<<IMAGEMAP
		<MAP name="imagemap-widget205local">
		<AREA alt="Production: nodac-RIB1284HF-54797799-2013" coords="80,207,102,229" data-epc="nodac-RIB1284HF-54797799-2013" data-localid="nodac-RIB1284HF-54797799-2013" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=BatchId%5BID%3Dnodac-RIB1284HF-54797799-2013%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-RIB1284HF-54797799-2013&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="BatchId%5BID%3Dnodac-RIB1284HF-54797799-2013%5D" shape="rect" title="Production: nodac-RIB1284HF-54797799-2013"/>
		<AREA alt="Production: nodac-RIB1284HF-50175050-2013" coords="262,207,284,229" data-epc="nodac-RIB1284HF-50175050-2013" data-localid="nodac-RIB1284HF-50175050-2013" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=BatchId%5BID%3Dnodac-RIB1284HF-50175050-2013%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-RIB1284HF-50175050-2013&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="BatchId%5BID%3Dnodac-RIB1284HF-50175050-2013%5D" shape="rect" title="Production: nodac-RIB1284HF-50175050-2013"/>
		<AREA alt="Finished Product: nodac-4014348000031 RIB1284HF-50175050-2013 6200823471" coords="444,185,451,173,465,173,472,185,465,197,451,197,444,185" data-epc="nodac-4014348000031 RIB1284HF-50175050-2013 6200823471" data-localid="nodac-4014348000031+RIB1284HF-50175050-2013+6200823471" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=TradeUnitId%5BID%3Dnodac-4014348000031+RIB1284HF-50175050-2013+6200823471%2C+global%3Dno%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-4014348000031+RIB1284HF-50175050-2013+6200823471&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="TradeUnitId%5BID%3Dnodac-4014348000031+RIB1284HF-50175050-2013+6200823471%2C+global%3Dno%5D" shape="poly" title="Finished Product: nodac-4014348000031 RIB1284HF-50175050-2013 6200823471"/>
		<AREA alt="Finished Product: nodac-4014348000031 RIB1300HF-50175050-2013 6200823471" coords="444,211,451,199,465,199,472,211,465,223,451,223,444,211" data-epc="nodac-4014348000031 RIB1300HF-50175050-2013 6200823471" data-localid="nodac-4014348000031+RIB1300HF-50175050-2013+6200823471" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=TradeUnitId%5BID%3Dnodac-4014348000031+RIB1300HF-50175050-2013+6200823471%2C+global%3Dno%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-4014348000031+RIB1300HF-50175050-2013+6200823471&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="TradeUnitId%5BID%3Dnodac-4014348000031+RIB1300HF-50175050-2013+6200823471%2C+global%3Dno%5D" shape="poly" title="Finished Product: nodac-4014348000031 RIB1300HF-50175050-2013 6200823471"/>
		<AREA alt="Finished Product: nodac-4014348000031 RIB1306HF-50175050-2013 6200823471" coords="444,237,451,225,465,225,472,237,465,249,451,249,444,237" data-epc="nodac-4014348000031 RIB1306HF-50175050-2013 6200823471" data-localid="nodac-4014348000031+RIB1306HF-50175050-2013+6200823471" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=TradeUnitId%5BID%3Dnodac-4014348000031+RIB1306HF-50175050-2013+6200823471%2C+global%3Dno%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-4014348000031+RIB1306HF-50175050-2013+6200823471&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="TradeUnitId%5BID%3Dnodac-4014348000031+RIB1306HF-50175050-2013+6200823471%2C+global%3Dno%5D" shape="poly" title="Finished Product: nodac-4014348000031 RIB1306HF-50175050-2013 6200823471"/>
		<AREA alt="Outgoing Shipment: nodac-4014348000031 2013 6200823471" coords="632,211,639,199,653,199,660,211,653,223,639,223,632,211" data-epc="nodac-4014348000031 2013 6200823471" data-localid="nodac-4014348000031+2013+6200823471" data-node="1000000601100025" href="?origin=nodac-4014348000031 2013 6200823471&amp;focus=TradeUnitId%5BID%3Dnodac-4014348000031+2013+6200823471%2C+global%3Dno%5D&amp;type=local&amp;key=widget205&amp;focusLocalId=nodac-4014348000031+2013+6200823471&amp;nodeId=1000000601100025&amp;imageMapName=imagemap-widget205local&amp;includeImgTag=false&amp;width=742&amp;height=400" id="TradeUnitId%5BID%3Dnodac-4014348000031+2013+6200823471%2C+global%3Dno%5D" shape="poly" title="Outgoing Shipment: nodac-4014348000031 2013 6200823471"/>
		</MAP>
IMAGEMAP;
		
		$this->tixErrorString = <<<TIXERROR
		<html>
		<head><title>JBoss Web/7.0.17.Final - Error report</title>
		<style>
		<!--H1 {
		font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:22px;} 
		H2 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:16px;} 
		H3 {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;font-size:14px;} 
		BODY {font-family:Tahoma,Arial,sans-serif;color:black;background-color:white;} 
		B {font-family:Tahoma,Arial,sans-serif;color:white;background-color:#525D76;} 
		P {font-family:Tahoma,Arial,sans-serif;background:white;color:black;font-size:12px;}
		A {color : black;}A.name {color : black;}HR {color : #525D76;}--></style> 
		</head><body><h1>HTTP Status 401 - Full authentication is required to access this resource</h1>
		<HR size="1" noshade="noshade"><p><b>type</b> Status report</p><p><b>message</b> 
		<u>Full authentication is required to access this resource</u></p>
		<p><b>description</b> <u>This request requires HTTP authentication (Full authentication is required to access this resource).</u></p>
		<HR size="1" noshade="noshade"><h3>JBoss Web/7.0.17.Final</h3>
		</body>
		</html>
TIXERROR;
		$this->tixErrorString = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->tixErrorString );
		$this->tixUpdateGnsResultXml = <<<GNSCACHEUPDATE
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<ns8:gnsResult xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" 
		xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" 
		xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:ttdata="http://www.tracetracker.com/data" 
		xmlns:ns8="http://schema.tracetracker.com/tixApi"><nodeId>0800000033000110</nodeId><message>Node for 0800000033000110 was updated.</message>
		<status>UPDATED</status></ns8:gnsResult>
GNSCACHEUPDATE;
		$this->tixUpdateGnsResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->tixUpdateGnsResultXml );
		$this->tixEpcisCaptureXml = <<<CAPTURE
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<collection/>
CAPTURE;
	$this->tixEpcisCaptureXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->tixEpcisCaptureXml );
	$this->graphXml = <<<GRAPH
	<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
	<graph xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:epcisq="urn:epcglobal:epcis-query:xsd:1" 
	xmlns:gqi="http://www.tracetracker.com/gqiresult" xmlns:epcismd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:epcis="urn:epcglobal:epcis:xsd:1" 
	xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:ttdata="http://www.tracetracker.com/data">
	    <node id="GAN[1000000601100016]" gan="1000000601100016">
	        <data key="type">gan</data>
	        <data key="sublabel">Ludwigshafen</data>
	        <data key="label">BASF</data>
	        <data key="certificate">invalid</data>
	        <data key="geolocation-latlong">53.4084,2.9916</data>
	    </node>
	    <node id="GAN[1000000601100025]" gan="1000000601100025">
	        <data key="type">gan</data>
	        <data key="sublabel">SEA (RDC)</data>
	        <data key="label">BASF</data>
	        <data key="local">yes</data>
	        <data key="geolocation-latlong">51.5073,-0.1277</data>
	        <data key="certificate">valid</data>
	    </node>
	    <edge source="GAN[1000000601100016]" target="GAN[1000000601100025]"/>
	</graph>
GRAPH;
	$this->graphXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->graphXml );
	$this->tixCapureData = <<<DATA
	<ObjectEvent>
	<eventTime>2014-01-09T08:58:36+03:00</eventTime>
	<eventTimeZoneOffset>+03:00</eventTimeZoneOffset>
	<epcList><epc>patjayke@gmail.com</epc></epcList>
	<action>OBSERVE</action>
	<bizStep>urn:gtnet:bizstep:user:nodechange</bizStep>
	<disposition>urn:epcglobal:cbv:disp:in_progress</disposition>
	<bizLocation><id>http://localhost/Story</id></bizLocation>
	<ttdata:fullName>James Njoroge</ttdata:fullName>
	<ttdata:username>patjayke@gmail.com</ttdata:username>
	<ttdata:email>patjayke@gmail.com</ttdata:email>
	<ttdata:roles>ROLE_CONSOLE, ROLE_DATA_IMPORTER, ROLE_SUPERADMIN, ROLE_ADMIN, ROLE_API, ROLE_TT, ROLE_TTADMIN, ROLE_WORKER, ROLE_WEB</ttdata:roles>
	<ttdata:organizationId>0800002873</ttdata:organizationId>
	<ttdata:organizationName>AEPC</ttdata:organizationName>
	<ttdata:ipAddress>127.0.0.1</ttdata:ipAddress>
	<ttdata:userAgent>Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:26.0) Gecko/20100101 Firefox/26.0</ttdata:userAgent>
	<ttdata:loginTime>2014-01-09T08:58:25+03:00</ttdata:loginTime>
	<ttdata:nodeVisited>0800002873000013</ttdata:nodeVisited>
	</ObjectEvent>
DATA;

	}
	/**
	 * configureStub 
	 * @param  mixed $returnValue What should returned from the TIX query
	 * @return void
	 */
	private function configureStub( $returnValue = true ) {

		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $returnValue ) );
		// ->with( $this->equalTo($xml));
		$this->curl->expects( $this->atLeastOnce() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_VALUE ) );
		// $this->curl->expects( $this->once() )
		//              ->method('multiGetContent')
		//              ->will( $this->returnValue(""));
		$this->curl->expects( $this->once() )
		->method( 'errno' )
		->will( $this->returnValue( false ) );
		// $this->curl->expects( $this->any() )
		//              ->method('error')
		//              ->will( $this->returnValue(null));
		//$this->curl->expects( $this->exactly(2) )
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );
		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

	}
	/**
	 * testTixQueryEpcis 
	 * @return void
	 */
	public function testTixQueryEpcis() {
		$this->configureStub($this->eventQueryResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixQueryEpcis($this->query);
		// print_r($tixResult->{0}->eventType); die();
		$this->assertInstanceOf('stdClass', $tixResult, 'Returned object is not an instasnce of stdClass');
		$this->assertAttributeNotEmpty('eventType', $tixResult->{0});
		$this->assertAttributeNotEmpty('eventTime', $tixResult->{0});
		$this->assertAttributeNotEmpty('recordTime', $tixResult->{0});
		$this->assertAttributeNotEmpty('epc', $tixResult->{0});
		$this->assertAttributeNotEmpty('action', $tixResult->{0});
		$this->assertAttributeNotEmpty('bizStep', $tixResult->{0});
		$this->assertAttributeNotEmpty('disposition', $tixResult->{0});
		$this->assertAttributeNotEmpty('readPoint', $tixResult->{0});
		$this->assertAttributeNotEmpty('bizLocation', $tixResult->{0});
		$this->assertAttributeNotEmpty('http://www.globaltraceability.net/schema/epcis#party_id', $tixResult->{0});
		$this->assertAttributeNotEmpty('http://www.globaltraceability.net/schema/epcis#party_id_type', $tixResult->{0});
		$this->assertAttributeNotEmpty('http://www.globaltraceability.net/schema/epcis#entityClass', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.globaltraceability.net/schema/epcis#trdType', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#dateshipped', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#customername', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#customernameMD', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#packingfacilitynameMD', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#unloadingpoint', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#packingfacility', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#transportername', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#truckid', $tixResult->{1});
		$this->assertAttributeEmpty('http://www.tracetracker.com/data#transportattachment', $tixResult->{1});
		$this->assertAttributeEmpty('http://www.tracetracker.com/data#deliverynoteid', $tixResult->{1});
		$this->assertAttributeNotEmpty('http://www.tracetracker.com/data#deliveryyear', $tixResult->{1});
		$this->assertAttributeEmpty('http://www.tracetracker.com/data#shipmentdescription', $tixResult->{1});
		
	}
	/**
	 * testTixQueryEpcisEmptyResult
	 * @return void
	 */
	public function testTixQueryEpcisEmptyResult() {
		$this->configureStub($this->emptyResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixQueryEpcis($this->query);
		// print_r($tixResult); die();
		$this->assertInstanceOf('stdClass', $tixResult, 'Returned object is not an instasnce of stdClass');
		$this->assertAttributeEquals($this->emptyErrorCode, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->emptyErrorDescription, $this->emptyErrorDescriptionAttribute, $tixResult);
	}
	/**
	 * testEventCount 
	 * @return void
	 */
	public function testEventCount() {
		$this->configureStub(self::EVENT_COUNT_RESULT);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->eventCount($this->query);
		// print_r($tixResult); die();
		$this->assertInstanceOf('stdClass', $tixResult, 'Returned object is not an instasnce of stdClass');
		$this->assertAttributeEquals(self::EVENT_COUNT_RESULT, 'count', $tixResult);

	}

	/**
	 * testTixQueryObjectDetails 
	 * @return void
	 */
	public function testTixQueryObjectDetails() {
		$this->configureStub($this->objectResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$query = $this->query;
		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixQueryObjectDetails($this->query);
		// print_r($tixResult); die();
		$this->assertInstanceOf('stdClass', $tixResult, 'Returned object is not an instasnce of stdClass');
		$this->assertAttributeNotEmpty('__nodeId', $tixResult->{0});
		$this->assertAttributeNotEmpty('epc', $tixResult->{0});
		$this->assertAttributeNotEmpty('entityClass', $tixResult->{0});
		$this->assertAttributeNotEmpty('label', $tixResult->{0});
		$this->assertAttributeNotEmpty('description', $tixResult->{0});
		$this->assertAttributeNotEmpty('created', $tixResult->{0});
		$this->assertAttributeNotEmpty('quantityunitofmeasure', $tixResult->{0});
		$this->assertAttributeNotEmpty('expectedharvest', $tixResult->{0});
		$this->assertAttributeNotEmpty('croptype', $tixResult->{0});
		$this->assertAttributeNotEmpty('season', $tixResult->{0});
		$this->assertAttributeNotEmpty('trdType', $tixResult->{0});
		$this->assertAttributeNotEmpty('seedgmo', $tixResult->{0});
		$this->assertAttributeNotEmpty('readPoint', $tixResult->{0});
		$this->assertAttributeNotEmpty('bizLocation', $tixResult->{0});
		$this->assertAttributeNotEmpty('parentcroptype', $tixResult->{0});
		$this->assertAttributeNotEmpty('plantingdate', $tixResult->{0});
		$this->assertAttributeNotEmpty('expectedvolume', $tixResult->{0});
		$this->assertAttributeNotEmpty('lastEventTime', $tixResult->{0});
		$this->assertAttributeNotEmpty('lastPropertyTime', $tixResult->{0});

	}
	/**
	 * testTixQueryObjectDetailsEmptyResult 
	 * @return void
	 */
	public function testTixQueryObjectDetailsEmptyResult() {
		$this->configureStub($this->emptyResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixQueryObjectDetails($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals($this->emptyErrorCode, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->emptyErrorDescription, $this->emptyErrorDescriptionAttribute, $tixResult);
	}

	/**
	 * testGetTradingPartners 
	 * @return void
	 */
	public function testGetTradingPartners() {
		$this->configureStub($this->tradingPartnersXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->getTradingPartners($this->query, $this->tixNodeId, $this->tradingPartnerFromDate, $this->tradingPartnerToDate);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertEquals($this->tradingPartnerResult, $tixResult->result, 'Trading partners result does not match expected');
	}

	/**
	 * testGetTradingPartnersEmptyResult
	 * @return void
	 */
	public function testGetTradingPartnersEmptyResult() {
		$this->configureStub($this->tradingPartnersEmptyXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->getTradingPartners($this->query, $this->tixNodeId, $this->tradingPartnerFromDate, $this->tradingPartnerToDate);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertEmpty($tixResult->result, 'Expecting an empty result from passing an XML with no attributes on testGetTradingPartnersEmptyResult');
	}

	/**
	 * testGetTradingPartnersWithError
	 * @return void
	 */
	public function testGetTradingPartnersWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $this->tradingPartnersEmptyXml ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->getTradingPartners($this->query, $this->tixNodeId, $this->tradingPartnerFromDate, $this->tradingPartnerToDate);
		// print_r($tixResult); die();
		$this->assertObjectNotHasAttribute('result', $tixResult, 'The attribute "result" should not be present - testGetTradingPartnersWithError');
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_DESRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_CODE, $this->emptyErrorCodeAttribute, $tixResult);

	}

	/**
	 * testTrdDetails
	 * @return void
	 */
	public function testTrdDetails() {
		$this->configureStub($this->trdXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->trdDetails($this->query, $this->tixNodeId, $this->tradingPartnerFromDate, $this->tradingPartnerToDate);
		// print_r($tixResult); die();
		// var_dump(count((array) $tixResult->result->TradeUnitType->{0})); die();
		// sorry for the magic numbers but i cant think of a better way to do this.
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertEquals(10, count((array)$tixResult->result->PropertyType));
		$this->assertEquals(5, count((array) $tixResult->result->TradeUnitType));
		$this->assertEquals(3, count((array) $tixResult->result->TradeUnitType->{0}));
		$this->assertEquals(4, count((array) $tixResult->result->TradeUnitType->{1}));
		$this->assertEquals(6, count($tixResult->result->TradeUnitType->{1}->PropertyRef));
		$this->assertEquals(3, count((array) $tixResult->result->TradeUnitType->{2}));
		$this->assertEquals(4, count((array) $tixResult->result->TradeUnitType->{3}));
		$this->assertEquals(5, count($tixResult->result->TradeUnitType->{3}->PropertyRef));
		$this->assertEquals(3, count((array) $tixResult->result->TradeUnitType->{4}));


	}

	/**
	 * testTrdDetailsWithError 
	 * @return void
	 */
	public function testTrdDetailsWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->trdDetails($this->query, $this->tixNodeId, $this->tradingPartnerFromDate, $this->tradingPartnerToDate);
		// print_r($tixResult); die();
		$this->assertObjectNotHasAttribute('result', $tixResult, 'The attribute "result" should not be present - testTrdDetailsWithError');
		$this->assertAttributeEquals(self::NO_TRD, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_CODE, $this->emptyErrorCodeAttribute, $tixResult);
	}
	/**
	 * testObjectCount
	 * @return void
	 */
	public function testObjectCount() {
		$this->configureStub($this->objectCountResult);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					//print_r( $arg );
					if ( $param1 == CURLOPT_NOBODY ) {
						$this->assertTrue($arg, 'CURLOPT_NOBODY should be set to true - testObjectCount');

					}

					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertTrue($arg, 'CURLOPT_HEADER should be set to true - testObjectCount');
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->objectCount($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		// $this->assertEmpty($tixResult->result, 'Expecting an empty result from passing an XML with no attributes on testGetTradingPartnersEmptyResult');
		$this->assertArrayHasKey("TT-Count", $tixResult->result, 'Result array should contain TT-Count - testObjectCount');
		$this->assertEquals("17", $tixResult->result['TT-Count'], 'TT-Count should be 17 - testObjectCount');

	}
	/**
	 * testOrgMapping description
	 * @return void
	 */
	public function testOrgMapping() {
		$this->configureStub($this->orgMappingResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_URL ) {
						$expectedOrgMappingQuery = $this->tixUrl . '/api/xml/admin/orgMapping?nodeId=' . $this->tixNodeId;
						$this->assertStringMatchesFormat("$expectedOrgMappingQuery%a", $arg, 'Orgmappiing query does not match expected - testOrgMapping');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->orgMapping($this->tixUrl, $this->tixNodeId);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertEquals($this->orgMappingResult, $tixResult->result);

	}
	/**
	 * testOrgMappingWithType
	 * @return void
	 */
	public function testOrgMappingWithType() {
		$this->configureStub($this->orgMappingResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_URL ) {
						$expectedOrgMappingQuery = $this->tixUrl . '/api/xml/admin/orgMapping?nodeId=' . $this->tixNodeId . '&type=ORG_ID';
						$this->assertStringMatchesFormat("$expectedOrgMappingQuery%a", $arg, 'Orgmappiing query does not match - testOrgMappingWithType');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->orgMapping($this->tixUrl, $this->tixNodeId, 'ORG_ID');
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertEquals($this->orgMappingResult, $tixResult->result);

	}
	/**
	 * testOrgMappingEmptyResponse
	 * @return void
	 */
	public function testOrgMappingEmptyResponse() {
		$this->configureStub($this->orgMappingEmptyXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_URL ) {
						$expectedOrgMappingQuery = $this->tixUrl . '/api/xml/admin/orgMapping?nodeId=' . $this->tixNodeId;
						$this->assertStringMatchesFormat("$expectedOrgMappingQuery%a", $arg, 'Orgmappiing query does not match expected - testOrgMapping');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->orgMapping($this->tixUrl, $this->tixNodeId);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);
		$this->assertAttributeEquals('ERROR: no records found', 'error', $tixResult);

	}
	/**
	 * testOrgMappingWithError()
	 * @return void
	 */
	public function testOrgMappingWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_URL ) {
						$expectedOrgMappingQuery = $this->tixUrl . '/api/xml/admin/orgMapping?nodeId=' . $this->tixNodeId;
						$this->assertStringMatchesFormat("$expectedOrgMappingQuery%a", $arg, 'Orgmappiing query does not match expected - testOrgMapping');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->orgMapping($this->tixUrl, $this->tixNodeId);
		// print_r($tixResult); die();
		$this->assertAttributeEquals('No orgmappings found', $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(28, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertObjectNotHasAttribute('result', $tixResult, 'The attribute "result" should not be present - testTrdDetailsWithError');
	}
	/**
	 * testCaptureOrgMapping
	 * @return void
	 */
	public function testCaptureOrgMapping() {
		$this->configureStub($this->query);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POST) {
						$this->assertTrue($arg);
					}
					if( $param1 == CURLOPT_POSTFIELDS) {
						$this->assertStringMatchesFormat($this->captureOrgMapXml, $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->captureOrgMapping($this->query, array('alias2'), '1000001053');
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);

	}
	/**
	 * testCaptureOrgMappingWithError
	 * @return void
	 */
	public function testCaptureOrgMappingWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POST) {
						$this->assertTrue($arg);
					}
					if( $param1 == CURLOPT_POSTFIELDS) {
						$this->assertStringMatchesFormat($this->captureOrgMapXml, $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->captureOrgMapping($this->query, array('alias2'), '1000001053');
		// print_r($tixResult); die();
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_DESRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_CODE, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);
	}
	/**
	 * testAboutDetails
	 * @return void
	 */	
	public function testAboutDetails() {
		$this->configureStub($this->aboutDetailsResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%a&ssoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->aboutDetails($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->aboutDetailsResult, 'result', $tixResult);

	}
	
	/**
	 * testAboutDetailsWithMasterData
	 * @return void
	 */	
	public function testAboutDetailsWithMasterData() {
		$this->configureStub($this->aboutDetailsMasterDataXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%a&ssoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->aboutDetails($this->query);
		$this->assertArrayHasKey("masterdata", $tixResult->result);
		$this->assertEquals($this->aboutDetailsMasterDataArray, $tixResult->result["masterdata"]);
		

	}

	/**
	 * testAboutDetailsSsoFirst
	 * @return void
	 */
	public function testAboutDetailsSsoFirst() {
		$this->configureStub($this->aboutDetailsResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%a?ssoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->aboutDetails('https://alpha.tracetracker.com/tix/api/xml/about/user', true);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->aboutDetailsResult, 'result', $tixResult);
	}
	/**
	 * testAboutDetailsWithError 
	 * @return void
	 */
	public function testAboutDetailsWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->aboutDetails($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_DESRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::TIMEOUT_ERROR_CODE, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);

	}
	/**
	 * testProcessGraphXml
	 * @return void
	 */
	public function testProcessGraphXml() {
		$this->configureStub($this->graphXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->processGraphXml($this->query);
		$this->assertCount(3, $tixResult->result);
		// print_r($tixResult); die();

	}

	/**
	 * testProcessGraphXmlError
	 * @return mixed
	 */
	public function testProcessGraphXmlError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->processGraphXml($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals('Request Timeout', $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals('28', $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertObjectNotHasAttribute('result', $tixResult);

	}
	/**
	 * testProcessGraphPng
	 * @return void
	 */
	public function testProcessGraphPng() {
		$this->configureStub($this->pngString);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->processGraphPng($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->pngResult, 'result', $tixResult);
	}
	/**
	 * testProcessGraphPngWithTimeoutError
	 * @return mixed
	 */
	public function testProcessGraphPngWithTimeoutError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->once() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::GET_INFO_RETURN_ERROR_VALUE ) );
		
		$this->curl->expects( $this->once() )
		->method( 'errno' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_CODE ) );
		$this->curl->expects( $this->never() )
		->method( 'error' )
		->will( $this->returnValue( self::TIMEOUT_ERROR_DESRIPTION ) );
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->processGraphPng($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(self::GRAPH_ERROR_DESCRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::GRAPH_ERROR_CODE, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);

	}

	public function testProcessGraphPngWithFiveHundredError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->once() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		
		$this->curl->expects( $this->once() )
		->method( 'errno' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		$this->curl->expects( $this->never() )
		->method( 'error' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->once() )
		->method( 'multiGetContent')
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED_DESCRIPTION));
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->processGraphPng($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(self::ERROR_FIVE_HUNDRED_DESCRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::ERROR_FIVE_HUNDRED, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);
	}

	public function testGetImageMap() {
		$this->configureStub($this->imageMapResult);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->getImageMap($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(null, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(null, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals($this->imageMapResult, 'result', $tixResult);
	}

	public function testGetImageMapWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if ( $param1 == CURLOPT_HEADER ) {
						$this->assertFalse($arg, 'Graph queries should not have headers in their responses');
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $this->tixErrorString ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		
		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );

		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED_DESCRIPTION ) );

		$this->curl->expects( $this->never() )
		->method( 'multiGetContent')
		->will( $this->returnValue( null ));
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->getImageMap($this->query);
		// print_r($tixResult); die();
		$this->assertAttributeEquals(self::ERROR_FIVE_HUNDRED_DESCRIPTION, $this->emptyErrorDescriptionAttribute, $tixResult);
		$this->assertAttributeEquals(self::ERROR_FIVE_HUNDRED, $this->emptyErrorCodeAttribute, $tixResult);
		$this->assertAttributeEquals(null, 'result', $tixResult);
	}

	public function testUpdateTixGnsCache() {
		$this->configureStub($this->tixUpdateGnsResultXml);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POST) {
						$this->assertTrue($arg);
					}
					if( $param1 == CURLOPT_POSTFIELDS) {
						$this->assertStringMatchesFormat("nodeId=0800002873000013&selected-nodeId=0800000033000110", $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->updateTixGnsCache($this->query, '0800002873000013', '0800000033000110');
		// print_r($tixResult); die();
		$this->assertAttributeEquals('0800000033000110', 'nodeId', $tixResult->result);
		$this->assertAttributeEquals('Node for 0800000033000110 was updated.', 'message', $tixResult->result);
		$this->assertAttributeEquals('UPDATED', 'status', $tixResult->result);

	}

	public function testUpdateTixGnsCacheWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POST) {
						$this->assertTrue($arg);
					}
					if( $param1 == CURLOPT_POSTFIELDS) {
						$this->assertStringMatchesFormat("nodeId=0800002873000013&selected-nodeId=0800000033000110", $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $this->tixErrorString ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED_DESCRIPTION ) );

		$this->curl->expects( $this->never() )
		->method( 'multiGetContent')
		->will( $this->returnValue( null ));
		
		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->updateTixGnsCache($this->query, '0800002873000013', '0800000033000110');
		// print_r($tixResult); die();
		$this->assertNull($tixResult->result);
		$this->assertEquals(self::ERROR_FIVE_HUNDRED, $tixResult->errorCode);
		$this->assertEquals(self::ERROR_FIVE_HUNDRED_DESCRIPTION, $tixResult->errorDescription);

	}

	public function testTixEpcisCapture() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POSTFIELDS) {
						$creationDate = date('Y-m-d') . 'T' . date('H:i');
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat('%aencoding="UTF-8"%a', $arg, 'encoding should be UTF-8');
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Incorrect creation date" );
					}

					if( $param1 == CURLOPT_HTTPHEADER) {
						$this->assertEquals(array('Content-type: application/xml'), $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
		->method( 'errno' )
		->will( $this->returnValue( null ) );

		$this->curl->expects( $this->never() )
		->method( 'error' );

		$this->curl->expects( $this->once() )
		->method( 'getInfo' )
		->will( $this->returnValue( 200 ) );

		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $this->tixEpcisCaptureXml ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixEpcisCapture($this->tixCapureData, $this->query);
		// print_r($tixResult); die();
		$this->assertNull($tixResult->errorCode);
		$this->assertNull($tixResult->errorDescription);
	}

	public function testTixEpcisCaptureWithError() {
		$this->curl = $this->getMock( 'TCurlResource' );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					$this->assertStringMatchesFormat( "%assoObject=%a", $arg );
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					if( $param1 == CURLOPT_POSTFIELDS) {
						$creationDate = date('Y-m-d') . 'T' . date('H:i');
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat('%aencoding="UTF-8"%a', $arg, 'encoding should be UTF-8');
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Incorrect creation date" );
					}

					if( $param1 == CURLOPT_HTTPHEADER) {
						$this->assertEquals(array('Content-type: application/xml'), $arg);
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->exactly(2) )
		->method( 'errno' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED ) );
		$this->curl->expects( $this->once() )
		->method( 'execute' )
		->will( $this->returnValue( $this->tixEpcisCaptureXml ) );

		$this->curl->expects( $this->never() )
		->method( 'getInfo' );
		
		$this->curl->expects( $this->once() )
		->method( 'error' )
		->will( $this->returnValue( self::ERROR_FIVE_HUNDRED_DESCRIPTION ) );

		$this->curl->expects( $this->any() )
		->method( 'getExecutionTime' )
		->will( $this->returnValue( 1 ) );

		$this->curl->expects( $this->any() )
		->method( 'close' )
		->will( $this->returnValue( null ) );

		$this->tixObject->setCurlResource($this->curl);
		$tixResult = $this->tixObject->tixEpcisCapture($this->tixCapureData, $this->query);
		// print_r($tixResult); die();
		$this->assertNull($tixResult->result);
		$this->assertEquals(self::ERROR_FIVE_HUNDRED, $tixResult->errorCode);
		$this->assertEquals(self::ERROR_FIVE_HUNDRED_DESCRIPTION, $tixResult->errorDescription);

	}

}
