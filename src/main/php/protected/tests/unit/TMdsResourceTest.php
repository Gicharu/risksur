<?php
/**
 * TMdsResourceTest
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
 */

class TMdsResourceTest extends PHPUnit_Framework_TestCase {

	private $curl;
	private $xml;
	private $creationDate;
	private $environment;
	private $query;
	private $vocabularyAndAtrributes;
	private $mds;
	private $vocabulary;
	private $queryParams;
	private $gnsOrgResultXml;
	private $gnsResult;
	private $mdsResult;
	private $mdsMddXml;
	private $mdsMddResult;
	private $mdsCountResult;
	private $gnsResultVocabulary;
	private $mdsResultVocabulary;
	private $mdsAttributeListXml;
	private $mdsAttributeCountResult;
	private $mdsAttributeNamesCountResult;
	private $mdsAttributeNamesXml;
	private $mdsAttributeNamesXmlError;
	const GET_INFO_RETURN_VALUE = 200;
	const REQUEST_TIMEOUT = 20000;
	/**
	 * setUp
	 */
	public function setUp() {
		//if ( ! extension_loaded( "apc" ) ) {
			//$this->markTestSkipped( "Required extension APC not available" );
		//}
		$this->xml = "<james></james>";
		$this->creationDate = 'creationDate="' . date( "c" ) . '"';
		$dateLength = strlen($this->creationDate);
		// stripping off the time zone and a digit from from the number of seconds to stop the tests from failing every now and then 
		$this->creationDate = substr($this->creationDate, 0, ($dateLength - 10));
		// echo $this->creationDate; //die();
		//$this->creationDate = 'creationDate="' . date("Y-m-d") . 'T' . date("h:i") . '"';
		$this->environment = Yii::app()->params->gns['environment'] . " MDD";
		$this->query = "includeAttributes=true&EQ_name=123";
		$this->vocabularyAndAtrributes = "vocabularyName=urn:tracetracker:mds:gns:organization&EQATTR_OID=1000000841";
		$this->vocabulary = "urn:tracetracker:mds:gns:organization";
		$this->queryParams = "&EQATTR_OID=1000000841";
		$this->mds = Yii::app()->mdsresource;
		$this->gnsResult = array( "id" => "urn:tracetracker:gns:organization:0800002819",
			"FN" => "Frode's fish and mermaids",
			"ON" => "frodesfish",
			"OID" => "0800002819",
			"C" => "NO",
			"LAST_MOD" => "2013-05-31T11:10:00+0200"
		);
		$this->gnsOrgResultXml = <<<GNS
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?><eq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis"
		xmlns:emd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:e="urn:epcglobal:epcis:xsd:1"
		xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:eq="urn:epcglobal:epcis-query:xsd:1">
		<queryName>SimpleMasterDataQuery</queryName><resultsBody><VocabularyList><Vocabulary type="urn:tracetracker:mds:gns:organization" accessGroup="0">
		<VocabularyElementList><VocabularyElement accessGroup="0" id="urn:tracetracker:gns:organization:0800002819">
		<attribute accessGroup="0" id="FN">Frode's fish and mermaids</attribute><attribute accessGroup="0" id="ON">frodesfish</attribute>
		<attribute accessGroup="0" id="OID">0800002819</attribute><attribute accessGroup="0" id="C">NO</attribute>
		<attribute accessGroup="0" id="LAST_MOD">2013-05-31T11:10:00+0200</attribute></VocabularyElement></VocabularyElementList></Vocabulary></VocabularyList>
		</resultsBody></eq:QueryResults>
GNS;
		$this->gnsOrgResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->gnsOrgResultXml );
		$this->mdsResultXml = <<<MDS
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?><eq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis"
		xmlns:emd="urn:epcglobal:epcis-masterdata:xsd:1" xmlns:e="urn:epcglobal:epcis:xsd:1"
		xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" xmlns:eq="urn:epcglobal:epcis-query:xsd:1">
		<queryName>SimpleMasterDataQuery</queryName><resultsBody><VocabularyList><Vocabulary type="urn:tracetracker:0800002873:story:config" accessGroup="0">
		<VocabularyElementList><VocabularyElement accessGroup="0" id="urn:tracetracker:0800002873:story:config:design">
		<attribute accessGroup="0" id="backgroundpath">images/headerBackground.png</attribute><attribute accessGroup="0" id="moreinfobuttonclass">ui-icon-info
		</attribute><attribute accessGroup="0" id="moreinfobuttonurl">http://docs.tracetracker.com/story</attribute>
		<attribute accessGroup="0" id="moreinfobuttontext">More Information</attribute><attribute accessGroup="0" id="theme">humanity/jquery-ui-1.9.2.custom.css
		</attribute><attribute accessGroup="0" id="logopath">images/logoStory.png</attribute>
		<attribute accessGroup="0" id="legendbuttontext">Legend</attribute><attribute accessGroup="0" id="helpdocumentpath">http://docs.tracetracker.com/story
		</attribute></VocabularyElement><VocabularyElement accessGroup="0" id="urn:tracetracker:0800002873:story:config:resources">
		<attribute accessGroup="0" id="locationNameAttribute">urn:tracetracker:asset:mda:loc_name</attribute><attribute accessGroup="0" id="locationNameVocabulary">
		urn:epcglobal:epcis:vtype:BusinessLocation</attribute><attribute accessGroup="0" id="geoCoordinatesExtension">geo_location</attribute>
		<attribute accessGroup="0" id="geoCoordinatesExtensionNamespace">http://www.tracetracker.com/data</attribute><attribute accessGroup="0" id="userAdminUrl">
		https://test.tracetracker.com/tracii/</attribute></VocabularyElement>
		<VocabularyElement accessGroup="0" id="urn:tracetracker:0800002873:story:config:widgets">
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:shipmentsWidget">false</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:widget6">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:organizationManagementWidget">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:widget5">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:productQuantityWidget">false</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:eventStatisticsWidget">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:widget1">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:userManagementWidget">true</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:objectDetailsWidget">false</attribute>
		<attribute accessGroup="0" id="urn:tracetracker:story:dashboardWidgets:geoLocationWidget">false</attribute></VocabularyElement></VocabularyElementList>
		</Vocabulary></VocabularyList></resultsBody></eq:QueryResults>
MDS;
		$this->mdsResultXml = str_replace( array( "\r\n", "\r", "\n", "\t" ), "", $this->mdsResultXml );
		$this->mdsResult =  array(
			array(
				"id" => "urn:tracetracker:0800002873:story:config:design",
				"backgroundpath" => "images/headerBackground.png",
				"moreinfobuttonclass" => "ui-icon-info",
				"moreinfobuttonurl" => "http://docs.tracetracker.com/story",
				"moreinfobuttontext" => "More Information",
				"theme" => "humanity/jquery-ui-1.9.2.custom.css",
				"logopath" => "images/logoStory.png",
				"legendbuttontext" => "Legend",
				"helpdocumentpath" => "http://docs.tracetracker.com/story"
			),
			array(
				"id" => "urn:tracetracker:0800002873:story:config:resources",
				"locationNameAttribute" => "urn:tracetracker:asset:mda:loc_name",
				"locationNameVocabulary" => "urn:epcglobal:epcis:vtype:BusinessLocation",
				"geoCoordinatesExtension" => "geo_location",
				"geoCoordinatesExtensionNamespace" => "http://www.tracetracker.com/data",
				"userAdminUrl" => "https://test.tracetracker.com/tracii/"
			),
			array(
				"id" => "urn:tracetracker:0800002873:story:config:widgets",
				"urn:tracetracker:story:dashboardWidgets:shipmentsWidget" => "false",
				"urn:tracetracker:story:dashboardWidgets:widget6" => "true",
				"urn:tracetracker:story:dashboardWidgets:organizationManagementWidget" => "true",
				"urn:tracetracker:story:dashboardWidgets:widget5" => "true",
				"urn:tracetracker:story:dashboardWidgets:productQuantityWidget" => "false",
				"urn:tracetracker:story:dashboardWidgets:eventStatisticsWidget" => "true",
				"urn:tracetracker:story:dashboardWidgets:widget1" => "true",
				"urn:tracetracker:story:dashboardWidgets:userManagementWidget" => "true",
				"urn:tracetracker:story:dashboardWidgets:objectDetailsWidget" => "false",
				"urn:tracetracker:story:dashboardWidgets:geoLocationWidget" => "false"
			)
		);
		$this->mdsMddXml = <<<MDSMDD
		<?xml version="1.0" encoding="UTF-8"?><tt:MDDef xmlns:tt="http://www.tracetracker.com/mdd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		id="exampleMDD" version="1.0" xsi:schemaLocation="http://www.tracetracker.com/mdd http://schema.tracetracker.com/ttMDD_1_0.xsd"><Label>
		<Text xml:lang="en">TEST MDD</Text></Label><Description><Text xml:lang="en">This is the MDD for the TEST environment, updated by Story</Text></Description>
		<Vocabulary id="urn:tracetracker:1000000656:story:users"/><Vocabulary id="urn:tracetracker:0800002819:story:users"/>
		<Vocabulary id="urn:tracetracker:tix:epcistesting:jmetertest"/>	<Vocabulary id="urn:epcglobal:epcis:vtype:EPCClass"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:BusinessStep"/><Vocabulary id="urn:epcglobal:epcis:vtype:Disposition"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:BusinessTransactionType"/><Vocabulary id="urn:epcglobal:epcis:vtype:BusinessLocation"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:ReadPoint"/><Vocabulary id="urn:tracetracker:mds:gns:organization"/>
		<Vocabulary id="urn:tracetracker:mds:gns:node"/><Vocabulary id="urn:tracetracker:mds:gns:message"/>
		<Vocabulary id="urn:tracetracker:mds:gns:service"/><Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary1"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary2"/><Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary3"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary4"/><Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary5"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary6"/><Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary7"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary8"/><Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary9"/>
		<Vocabulary id="urn:epcglobal:epcis:vtype:Vocabulary10"/><Vocabulary id="urn:epcglobal:epcis:vtype:DummyData"/>
		<Vocabulary id="urn:tracetracker:tix:trd:fish:ice:orderno"/><Vocabulary id="urn:tracetracker:tix:trd:fish:ice:product"/>
		<Vocabulary id="urn:tracetracker:tix:trd:fish:ice:supplier"/><Vocabulary id="urn:epcglobal:epcis:vtype:Partner"/>
		<Vocabulary id="urn:tracetracker:1000000531:asset:dictionary"/><Vocabulary id="urn:tracetracker:asset:vtype:categories"/>
		<Vocabulary id="urn:tracetracker:1:asset:users"/><Vocabulary id="urn:tracetracker:1:asset:users:labels"/>
		<Vocabulary id="urn:tracetracker:1:asset:users:time:role:rules"/><Vocabulary id="urn:tracetracker:1:asset:users:time:rules"/>
		<Vocabulary id="urn:tracetracker:1:asset:config"/><Vocabulary id="urn:tracetracker:1:asset:locales"/>
		<Vocabulary id="urn:tracetracker:1:asset:dictionary"/><Vocabulary id="urn:tracetracker:1:asset:mapping"/>
		<Vocabulary id="urn:tracetracker:6729:asset:users"/><Vocabulary id="urn:tracetracker:6729:asset:users:labels"/>
		<Vocabulary id="urn:tracetracker:6729:asset:users:time:role:rules"/><Vocabulary id="urn:tracetracker:6729:asset:users:time:rules"/>
		<Vocabulary id="urn:tracetracker:6729:asset:config"/><Vocabulary id="urn:tracetracker:6729:asset:locales"/>
		<Vocabulary id="urn:tracetracker:6729:asset:dictionary"/><Vocabulary id="urn:tracetracker:6729:asset:mapping"/>
		</tt:MDDef>
MDSMDD;
		
		$this->mdsMddXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $this->mdsMddXml);

		$this->mdsMddResult = array(
				"0" => "urn:tracetracker:1000000656:story:users",
				"1" => "urn:tracetracker:0800002819:story:users",
				"2" => "urn:tracetracker:tix:epcistesting:jmetertest",
				"3" => "urn:epcglobal:epcis:vtype:EPCClass",
				"4" => "urn:epcglobal:epcis:vtype:BusinessStep",
				"5" => "urn:epcglobal:epcis:vtype:Disposition",
				"6" => "urn:epcglobal:epcis:vtype:BusinessTransactionType",
				"7" => "urn:epcglobal:epcis:vtype:BusinessLocation",
				"8" => "urn:epcglobal:epcis:vtype:ReadPoint",
				"9" => "urn:tracetracker:mds:gns:organization",
				"10" => "urn:tracetracker:mds:gns:node",
				"11" => "urn:tracetracker:mds:gns:message",
				"12" => "urn:tracetracker:mds:gns:service",
				"13" => "urn:epcglobal:epcis:vtype:Vocabulary1",
				"14" => "urn:epcglobal:epcis:vtype:Vocabulary2",
				"15" => "urn:epcglobal:epcis:vtype:Vocabulary3",
				"16" => "urn:epcglobal:epcis:vtype:Vocabulary4",
				"17" => "urn:epcglobal:epcis:vtype:Vocabulary5",
				"18" => "urn:epcglobal:epcis:vtype:Vocabulary6",
				"19" => "urn:epcglobal:epcis:vtype:Vocabulary7",
				"20" => "urn:epcglobal:epcis:vtype:Vocabulary8",
				"21" => "urn:epcglobal:epcis:vtype:Vocabulary9",
				"22" => "urn:epcglobal:epcis:vtype:Vocabulary10",
				"23" => "urn:epcglobal:epcis:vtype:DummyData",
				"24" => "urn:tracetracker:tix:trd:fish:ice:orderno",
				"25" => "urn:tracetracker:tix:trd:fish:ice:product",
				"26" => "urn:tracetracker:tix:trd:fish:ice:supplier",
				"27" => "urn:epcglobal:epcis:vtype:Partner",
				"28" => "urn:tracetracker:1000000531:asset:dictionary",
				"29" => "urn:tracetracker:asset:vtype:categories",
				"30" => "urn:tracetracker:1:asset:users",
				"31" => "urn:tracetracker:1:asset:users:labels",
				"32" => "urn:tracetracker:1:asset:users:time:role:rules",
				"33" => "urn:tracetracker:1:asset:users:time:rules",
				"34" => "urn:tracetracker:1:asset:config",
				"35" => "urn:tracetracker:1:asset:locales",
				"36" => "urn:tracetracker:1:asset:dictionary",
				"37" => "urn:tracetracker:1:asset:mapping",
				"38" => "urn:tracetracker:6729:asset:users",
				"39" => "urn:tracetracker:6729:asset:users:labels",
				"40" => "urn:tracetracker:6729:asset:users:time:role:rules",
				"41" => "urn:tracetracker:6729:asset:users:time:rules",
				"42" => "urn:tracetracker:6729:asset:config",
				"43" => "urn:tracetracker:6729:asset:locales",
				"44" => "urn:tracetracker:6729:asset:dictionary",
				"45" => "urn:tracetracker:6729:asset:mapping"
			);
		$this->mdsCountResult = 10;
		$this->gnsResultVocabulary = array("urn:tracetracker:mds:gns:organization");
		$this->mdsResultVocabulary = array("urn:tracetracker:0800002873:story:config");
		//$this->configureStub();
		$this->mdsAttributeListXml = <<<ATTRIBLIST
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<eq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:emd="urn:epcglobal:epcis-masterdata:xsd:1" 
		xmlns:e="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" 
		xmlns:eq="urn:epcglobal:epcis-query:xsd:1" xmlns:ns7="http://www.tracetracker.com/data"><queryName>AttributeValueQuery</queryName><resultsBody>
		<VocabularyList>
		<Vocabulary type="urn:epcglobal:epcis:vtype:BusinessLocation">
		<ns7:attribute name="vendor_id">
		<value>100119</value>
		<value>100087</value>
		<value>100181</value>
		<value>100089</value>
		<value>100079</value>
		<value>100072</value>
		</ns7:attribute>
		</Vocabulary>
		</VocabularyList>
		</resultsBody>
		</eq:QueryResults>
ATTRIBLIST;
		$this->mdsAttributeListXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $this->mdsAttributeListXml);
		$this->mdsAttributeCountResult = 6;
		$this->mdsAttributeNamesXml = <<<ATTRIBNAME
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<eq:QueryResults xmlns:gtnet-epcis="http://www.globaltraceability.net/schema/epcis" xmlns:emd="urn:epcglobal:epcis-masterdata:xsd:1" 
		xmlns:e="urn:epcglobal:epcis:xsd:1" xmlns:sbdh="http://www.unece.org/cefact/namespaces/StandardBusinessDocumentHeader" 
		xmlns:eq="urn:epcglobal:epcis-query:xsd:1" xmlns:ns7="http://www.tracetracker.com/data">
		<queryName>AttributeNamesQuery</queryName>
		<resultsBody>
		<VocabularyList>
		<Vocabulary type="urn:epcglobal:epcis:vtype:BusinessLocation">
		<attributeName>company_cert_fssc22000</attributeName>
		<attributeName>company_city</attributeName>
		<attributeName>location1_id</attributeName>
		<attributeName>contact_seafood_email</attributeName>
		<attributeName>location6_country</attributeName>
		<attributeName>company_cert_sqf1000</attributeName>
		<attributeName>location3_countrycode</attributeName>
		<attributeName>location8_id</attributeName>
		</Vocabulary>
		</VocabularyList>
		</resultsBody>
		</eq:QueryResults>
ATTRIBNAME;
		$this->mdsAttributeNamesXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $this->mdsAttributeNamesXml);
		$this->mdsAttributeNamesCountResult = 8;

		$this->mdsAttributeNamesXmlError = <<<ATTRIBNAMEERROR
		<?xml version="1.0" encoding="UTF-8" standalone="yes"?><QueryResults xmlns:ns2="http://www.tracetracker.com/data">
		<queryName>AttributeNamesQuery</queryName>
		<errorMessage>'vocabularyName' param is required!</errorMessage>
		</QueryResults>
ATTRIBNAMEERROR;


		$this->mds->mdsClearApcCache();
	}

	/**
	 * configureStub
	 *
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
	 * testxxx
	 */
	// public function testxxx() {
	//  $xml = $this->xml;
	//        $mds = $this->setCallbackForSetOption( function( $arg ) use ($xml, &$param1) {
	//                        //echo "HB | $param1 | ". $xml . " |\n";
	//                        //print_r( $arg );
	//                        if( $param1 == CURLOPT_POSTFIELDS ) {
	//                            $creationDate = $this->creationDate;
	//                            $this->assertStringstartswith( "xxx<?xml", $arg, "Does not start with xml" );
	//                            $this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
	//                            $this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Incorrect creation date");

	//                        }
	//                        if( $param1 == CURLOPT_HTTPHEADER ) {
	//                            $this->assertEquals("nonOverwrite: false", $arg[1]);
	//                        }
	//                        return true;
	//                    });

	//        $result = $mds->mdsCapture($xml);

	//        $this->assertNotNull( $result );

	//    }
	/**
	 * setCallbackForSetOption
	 */
	//    public function setCallbackForSetOption( $callback ) {
	//        $xml = $this->xml;
	//        $param1;
	//        $this->configureStub();
	//        $this->curl->expects( $this->any() )
	//                    ->method('setOption')
	//                    ->with($this->callback(function( $arg ) use (&$param1) {
	//                        $param1 = $arg;
	//                        return true;
	//                    }),
	//                    $this->callback( $callback ))
	//                    ->will($this->returnValue(true));

	//        $mds = $this->mds;
	//        $mds->setCurlResource( $this->curl );

	//        return $mds;

	//    }
	/**
	 * testMdsCaptureNonOverwirte
	 *
	 * @return bool
	 */
	public function testMdsCaptureNonOverwirte() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$creationDate = $this->creationDate;
						// print_r( $creationDate ); die();
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat('%aencoding="UTF-8"%a', $arg, 'encoding should be UTF-8');
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Incorrect creation date" );
					}
					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: false", $arg[1] );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsCapture( $xml );

		//var_dump($result);


		$this->assertNotNull( $result );

	}


	/**
	 * testMdsCaptureMddNonOverwrite
	 *
	 * @return bool
	 */
	public function testMdsCaptureMddNonOverwrite() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$environment = $this->environment;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$environment%a", $arg, "MDD has wrong ENV" );

					}
					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: false", $arg[1] );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsCapture( $xml, "mdd" );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

	/**
	 * testMdsCaptureVocabOverwrite
	 *
	 * @return bool
	 *
	 */
	public function testMdsCaptureVocabOverwrite() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$creationDate = $this->creationDate;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "There should be no creation date" );

					}

					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: true", $arg[1] );
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );



		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );
		$result = $mds->mdsCapture( $xml, "vocab", true );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

	/**
	 * testMdsCaptureMddOverwrite
	 *
	 * @return bool
	 *
	 */
	public function testMdsCaptureMddOverwrite() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$environment = $this->environment;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$environment%a", $arg, "MDD has wrong ENV" );

					}

					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: true", $arg[1] );
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsCapture( $xml, "mdd", true );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

	/**
	 * testMdsCaptureGnsVocabOverwrite
	 *
	 * @return bool
	 *
	 */
	public function testMdsCaptureGnsVocabOverwrite() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$creationDate = $this->creationDate;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "There should be no creation date" );

					}

					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: true", $arg[1] );
					}

					if ( $param1 == CURLOPT_USERPWD ) {
						$usr = Yii::app()->params->gns['adminUser'];
						$pass = Yii::app()->params->gns['adminPassword'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsCapture( $xml, "vocab", true, "gns" );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

	/**
	 * testMdsCaptureGnsMddOverwrite
	 *
	 * @return bool
	 *
	 */
	public function testMdsCaptureGnsMddOverwrite() {
		$xml = $this->xml;
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$environment = $this->environment;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$environment%a", $arg, "MDD has wrong ENV" );

					}

					if ( $param1 == CURLOPT_HTTPHEADER ) {
						$this->assertEquals( "nonOverwrite: true", $arg[1] );
					}

					if ( $param1 == CURLOPT_USERPWD ) {
						$usr = Yii::app()->params->gns['adminUser'];
						$pass = Yii::app()->params->gns['adminPassword'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsCapture( $xml, "mdd", true, "gns" );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

	/**
	 * testMdsDelete
	 *
	 * @return mixed
	 */
	public function testMdsDelete() {
		$xml = "";
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						$creationDate = $this->creationDate;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Incorrect creation date" );

					}
					if ( $param1 == CURLINFO_HEADER_OUT ) {
						$this->assertEquals( true, $arg );

					}
					if ( $param1 == CURLOPT_POST ) {
						$this->assertEquals( true, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsDelete( $xml );

		//var_dump($result);


		$this->assertNotNull( $result );

	}
	/**
	 * testGnsDelete
	 *
	 * @return mixed
	 */
	public function testGnsDelete() {
		$xml = "";
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( $xml, &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					if ( $param1 == CURLOPT_POSTFIELDS ) {
						//print_r( $arg );
						$creationDate = $this->creationDate;
						$this->assertStringstartswith( "<?xml", $arg, "Does not start with xml" );
						$this->assertStringMatchesFormat( "%a$xml%a", $arg, "XML does not contain input" );
						$this->assertStringMatchesFormat( "%a$creationDate%a", $arg, "Invalid creation date" );

					}

					if ( $param1 == CURLOPT_USERPWD ) {
						$usr = Yii::app()->params->gns['adminUser'];
						$pass = Yii::app()->params->gns['adminPassword'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$this->curl->expects( $this->once() )
			->method( 'init' )
			->with( $this->callback( function( $arg ) use ( &$param1 ) {
						$param1 = $arg;
						$this->assertStringMatchesFormat( "%a/api/rest/delete", $arg, "use delete endpoint" );
						return true;
					} ) 
			)
			->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->mdsDelete( $xml, "gns" );
		//var_dump($result); die();
		$this->assertNotNull( $result );


	}
	/**
	 * testMdsAttributeList 
	 * @return void
	 */
	public function testMdsAttributeList() {
		$query = $this->query;
		$param1;
		$mdsResultXml = $this->mdsAttributeListXml;
		$this->configureStub( $mdsResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringMatchesFormat( "%aAttributeValueQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					// check if we are sending username / password when querying MDS, if so we fail.
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->attributeListQuery( $query, 'cache');
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEmpty($result->error);
		$this->assertEquals($this->mdsAttributeCountResult, count($result->result['vendor_id']));
	}
	/**
	 * testAttributeNames 
	 * @return void
	 */
	public function testAttributeNames() {
		$query = $this->query;
		$param1;
		$mdsResultXml = $this->mdsAttributeNamesXml;
		$this->configureStub( $mdsResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
			//print_r($arg); die();
			$this->assertStringMatchesFormat( "%aAttributeNamesQuery?%a", $arg );
			$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					// check if we are sending username / password when querying MDS, if so we fail.
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->attributeNamesQuery( $query );
		// print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEmpty($result->error);
		$this->assertEquals($this->mdsAttributeNamesCountResult, count($result->result));


	}
	/**
	 * testAttributeNamesNoResults
	 * @return void
	 */
	public function testAttributeNamesNoResults() {
		$query = $this->query;
		$param1;
		$mdsResultXml = $this->mdsAttributeNamesXmlError;
		$this->configureStub( $mdsResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
			//print_r($arg); die();
			$this->assertStringMatchesFormat( "%aAttributeNamesQuery?%a", $arg );
			$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					// check if we are sending username / password when querying MDS, if so we fail.
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->attributeNamesQuery( $query );
		// print_r($result); die();
		$this->assertEmpty($result->result);
		$this->assertNotEmpty($result->error);
	}
	/**
	 * testMdsQueryGNSNoResults 
	 * @return bool
	 */
	public function testMdsQueryGNSNoResults() {
		$query = $this->query;
		$param1;
		$gnsOrgResultXml = $this->gnsOrgResultXml;
		$gnsResult = $this->gnsResult;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
			//print_r($arg); die();
					$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query", $arg );
					$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );

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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$usr =  Yii::app()->params->gns['username'];
						$pass = Yii::app()->params->gns['password'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );


		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->elementListMdsQuery( $query );
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEquals( "No results", $result->error );
	}
	/**
	 * testMdsQueryGNS
	 *
	 * @return bool
	 *
	 */
	public function testMdsQueryGNSSimple() {
		$query = $this->query;
		$param1;
		$gnsOrgResultXml = $this->gnsOrgResultXml;
		$gnsResult = $this->gnsResult;
		$this->configureStub( $gnsOrgResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query", $arg );
					$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );

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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$usr =  Yii::app()->params->gns['username'];
						$pass = Yii::app()->params->gns['password'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );


		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->elementListMdsQuery( $query, 'gns', 'cache', 'simple' );
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEquals( $gnsResult, $result->result[0] );
		$this->assertEmpty($result->error);

	}

	/**
	 * testMdsQueryMDSSimple 
	 * @return bool
	 */
	public function testMdsQueryMDSSimple() {
		$query = $this->query;
		$param1;
		$mdsResultXml = $this->mdsResultXml;
		$this->configureStub( $mdsResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					// check if we are sending username / password when querying MDS, if so we fail.
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->elementListMdsQuery( $query, "mds", 'cache', 'simple' );
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEmpty($result->error);
		$this->assertEquals($this->mdsResult, $result->result);

	}

	/**
	 * testMdsQueryGNSExtended
	 *
	 * @return bool
	 *
	 */
	public function testMdsQueryGNSExtended() {
		$query = $this->query;
		$param1;
		$gnsOrgResultXml = $this->gnsOrgResultXml;
		$gnsResult = $this->gnsResult;
		$this->configureStub( $gnsOrgResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );
					$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query", $arg );

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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$usr =  Yii::app()->params->gns['username'];
						$pass = Yii::app()->params->gns['password'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );
		$result = $mds->elementListMdsQuery( $query, "gns" );
		$this->assertNotNull( $result );
		$this->assertEquals( $gnsResult, $result->result[0] );
		$this->assertEmpty($result->error);


	}

	/**
	 * testMdsQueryMDSExtended
	 * @return bool
	 *
	 */
	public function testMdsQueryMDSExtended() {
		$query = $this->query;
		$param1;
		$mdsResultXml = $this->mdsResultXml;
		$this->configureStub( $mdsResultXml );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->elementListMdsQuery( $query, "mds" );
		$this->assertNotNull( $result );
		$this->assertEmpty($result->error);
		$this->assertEquals($this->mdsResult, $result->result);


	}

	/**
	 * testMdsQueryMdsCount
	 *
	 * @return bool
	 *
	 */
	public function testMdsQueryMDSCount() {
		$query = $this->query;
		$param1;
		$mdsCountResult = $this->mdsCountResult;
		$this->configureStub( $mdsCountResult );
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					$this->assertStringMatchesFormat( "%aCountMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query%a", $arg );
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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );
		$result = $mds->countMdsQuery( $query, "mds" );
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEquals($mdsCountResult, $result);


	}

	/**
	 * testMdsQueryGnsCount
	 * @return bool
	 */
	public function testMdsQueryGnsCount() {
		$query = $this->query;
		$param1;
		$mdsCountResult = $this->mdsCountResult;
		$this->configureStub($mdsCountResult);
		$this->curl->expects( $this->any() )
		->method( 'init' )
		->with( $this->callback( function( $arg ) {
					//print_r($arg); die();
					$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );
					$this->assertStringMatchesFormat( "%aCountMasterDataQuery?%a", $arg );
					$this->assertStringMatchesFormat( "%a$this->query", $arg );

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
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );
					if ( $param1 == CURLOPT_USERPWD ) {
						$usr =  Yii::app()->params->gns['username'];
						$pass = Yii::app()->params->gns['password'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}

					if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->countMdsQuery( $query, "gns" );
		//print_r($result); die();
		$this->assertNotNull( $result );
		$this->assertEquals($mdsCountResult, $result);


	}

	/**
	 * testMdsQueryGnsExtended
	 * @return bool
	 *
	 */
	//public function testMdsQueryGnsVocabularyExtended() {
		//$query = $this->query;
		//$param1;
		//$gnsOrgResultXml = $this->gnsOrgResultXml;
		//$this->configureStub( $gnsOrgResultXml );
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );
					//$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$usr =  Yii::app()->params->gns['username'];
						//$pass = Yii::app()->params->gns['password'];
						//$this->assertEquals( $usr . ':' . $pass, $arg );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "gns", "extended", "vocabulary" );
		////print_r($result); die();
		//$this->assertNotNull( $result );
		//$this->assertEquals($this->gnsResultVocabulary, $result->result);
		//$this->assertEmpty($result->error);


	//}

	/**
	 * testMdsQueryMDSExtended
	 *
	 * @return bool
	 *
	 */
	//public function testMdsQueryMDSVocabularyExtended() {
		//$query = $this->query;
		//$param1;
		//$mdsResultXml = $this->mdsResultXml;
		//$this->configureStub($mdsResultXml);
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "mds", "extended", "vocabulary" );
		////echo $query;
		////print_r($result); die();
		//$this->assertNotNull( $result );
		//$this->assertEquals($this->mdsResultVocabulary, $result->result);
		//$this->assertEmpty($result->error);
	//}

	/**
	 * testMdsQueryMDSMdd
	 *
	 * @return bool
	 *
	 */
	//public function testMdsQueryMDSMdd() {
		//$query = $this->query;
		//$param1;
		//$mdsMddXml = $this->mdsMddXml;
		//$this->configureStub( $mdsMddXml );
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "mds", "mdd", "vocabulary" );
		//$this->assertNotNull( $result );
		//$this->assertEmpty($result->error);
		//$this->assertEquals($this->mdsMddResult, $result->result);
	//}


	/**
	 * testMdsQueryGnsVocabularyExtendedNoCache 
	 * @return bool
	 */
	//public function testMdsQueryGnsVocabularyExtendedNoCache() {
		//$query = $this->query;
		//$param1;
		//$gnsOrgResultXml = $this->gnsOrgResultXml;
		//$this->configureStub( $gnsOrgResultXml );
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );
					//$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$usr =  Yii::app()->params->gns['username'];
						//$pass = Yii::app()->params->gns['password'];
						//$this->assertEquals( $usr . ':' . $pass, $arg );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "gns", "extended", "vocabulary", "noCache" );
		////print_r($result); die();
		//$this->assertNotNull( $result );
		//$this->assertEquals($this->gnsResultVocabulary, $result->result);
		//$this->assertEmpty($result->error);
		////$this->assertFalse(apc_cache_info());


	//}

	/**
	 * testMdsQueryMDSVocabularyExtendedNoCache 
	 * @return bool
	 */
	//public function testMdsQueryMDSVocabularyExtendedNoCache() {
		//$query = $this->query;
		//$param1;
		//$mdsResultXml = $this->mdsResultXml;
		//$this->configureStub($mdsResultXml);
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "mds", "extended", "vocabulary", "noCache" );
		////print_r($result); die();
		//$this->assertNotNull( $result );
		//$this->assertEquals($this->mdsResultVocabulary, $result->result);
		//$this->assertEmpty($result->error);
		////$this->assertFalse(apc_cache_info());


	//}

	/**
	 * testMdsQueryMDSMddNoCache
	 * @return bool
	 */
	//public function testMdsQueryMDSMddNoCache() {
		//$query = $this->query;
		//$param1;
		//$mdsMddXml = $this->mdsMddXml;
		//$this->configureStub( $mdsMddXml );
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "mds", "mdd", "vocabulary", "noCache" );
		////print_r($result); die();
		//$this->assertNotNull( $result );
		//$this->assertEmpty($result->error);
		//$this->assertEquals($this->mdsMddResult, $result->result);
		////$this->assertFalse(apc_cache_info());

	//}
	/**
	 * testMdsQueryMDSCountNoCache 
	 * @return bool
	 */
	//public function testMdsQueryMDSCountNoCache() {
		//$query = $this->query;
		//$param1;
		//$mdsCountResult = $this->mdsCountResult;
		//$this->curl = $this->getMock( 'TCurlResource' );
		//$this->curl->expects( $this->never() )
		//->method( 'execute' )
		//->will( $this->returnValue( null ) );
		
		//$this->curl->expects( $this->never() )
		//->method( 'getInfo' )
		//->will( $this->returnValue( self::GET_INFO_RETURN_VALUE ) );
		
		//$this->curl->expects( $this->never() )
		//->method( 'errno' )
		//->will( $this->returnValue( false ) );
		
		//$this->curl->expects( $this->any() )
		//->method( 'getExecutionTime' )
		//->will( $this->returnValue( 1 ) );
		//$this->curl->expects( $this->any() )
		//->method( 'close' )
		//->will( $this->returnValue( null ) );

		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%aCountMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
				//} ),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$this->fail( 'MDS queries should use the sso object, no usernames / passwords allowed!' );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );
		//$result = $mds->mdsQuery( $query, "mds", "count", "vocabulary", "noCache" );
		////print_r($result); die();
		//$this->assertNull( $result->result );
		//$this->assertEquals("Invalid combination of parameters", $result->error);
		////$this->assertFalse(apc_cache_info());

	//}

	/**
	 * testMdsQueryGnsCountNoCache
	 * @return bool
	 */
	//public function testMdsQueryGnsCountNoCache() {
		//$query = $this->query;
		//$param1;
		//$mdsCountResult = $this->mdsCountResult;
		//$this->curl = $this->getMock( 'TCurlResource' );
		//$this->curl->expects( $this->never() )
		//->method( 'execute' )
		//->will( $this->returnValue( null ) );
		
		//$this->curl->expects( $this->never() )
		//->method( 'getInfo' )
		//->will( $this->returnValue( self::GET_INFO_RETURN_VALUE ) );
		
		//$this->curl->expects( $this->never() )
		//->method( 'errno' )
		//->will( $this->returnValue( false ) );
		
		//$this->curl->expects( $this->any() )
		//->method( 'getExecutionTime' )
		//->will( $this->returnValue( 1 ) );
		//$this->curl->expects( $this->any() )
		//->method( 'close' )
		//->will( $this->returnValue( null ) );

		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringMatchesFormat( "%aCountMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );
					//$this->assertStringMatchesFormat( "%assoObject=%a", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );
		//$this->curl->expects( $this->any() )
		//->method( 'init' )
		//->with( $this->callback( function( $arg ) {
					////print_r($arg); die();
					//$this->assertStringNotMatchesFormat( "%aExtendedMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%aSimpleMasterDataQuery?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%amdd?%a", $arg );
					//$this->assertStringNotMatchesFormat( "%assoObject=%a", $arg );
					//$this->assertStringMatchesFormat( "%aCountMasterDataQuery?%a", $arg );
					//$this->assertStringMatchesFormat( "%a$this->query", $arg );

					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$this->curl->expects( $this->any() )
		//->method( 'setOption' )
		//->with( $this->callback( function( $arg ) use ( &$param1 ) {
					//$param1 = $arg;
					//return true;
			// }),
			//$this->callback( function( $arg ) use ( &$param1 ) {
					////echo "HB | $param1 | ". $xml . " |\n";
					////print_r( $arg );
					//if ( $param1 == CURLOPT_USERPWD ) {
						//$usr =  Yii::app()->params->gns['username'];
						//$pass = Yii::app()->params->gns['password'];
						//$this->assertEquals( $usr . ':' . $pass, $arg );
					//}

					//if ( $param1 == CURLOPT_CONNECTTIMEOUT_MS ) {
						//$this->assertEquals( self::REQUEST_TIMEOUT, $arg );
					//}
					//return true;
				//} ) )
		//->will( $this->returnValue( true ) );

		//$mds = $this->mds;
		//$mds->setCurlResource( $this->curl );

		//$result = $mds->mdsQuery( $query, "gns", "count", "vocabulary", "noCache" );

		//$this->assertNull( $result->result );
		//$this->assertEquals("Invalid combination of parameters", $result->error);
		////$this->assertFalse(apc_cache_info());

	//}
	/**
	 * testMdsQueryStringNoParam
	 *
	 */
	public function testMdsQueryStringNoParam() {
		$mds = $this->mds;
		$expectedFormat = "includeAttributes=true&includeChildren=false&";
		$result = $this->mds->mdsQueryString();
		$this->assertStringMatchesFormat($expectedFormat, $result);

	}

	/**
	 * testMdsQueryStringGetElement
	 *
	 */
	public function testMdsQueryStringGetElement() {
		$mds = $this->mds;
		$vocabularyAndAtrributes = $this->vocabularyAndAtrributes;
		$expectedFormat = "includeAttributes=true&includeChildren=false&" . $vocabularyAndAtrributes;
		$result = $this->mds->mdsQueryString($vocabularyAndAtrributes);
		$this->assertStringMatchesFormat($expectedFormat, $result);

	}
	/**
	 * testMdsQueryStringTwoParam
	 *
	 */
	public function testMdsQueryStringGetElementNoAttributes() {
		$mds = $this->mds;
		$vocabularyAndAtrributes = $this->vocabularyAndAtrributes;
		$expectedFormat = "includeAttributes=false&includeChildren=false&" . $vocabularyAndAtrributes;
		$result = $this->mds->mdsQueryString($vocabularyAndAtrributes, "false");
		$this->assertStringMatchesFormat($expectedFormat, $result);
	}
	/**
	 * testMdsQueryStringGetElementWithChildrenNoAttributes
	 *
	 */
	public function testMdsQueryStringGetElementWithChildrenNoAttributes() {
		$mds = $this->mds;
		$vocabularyAndAtrributes = $this->vocabularyAndAtrributes;
		$expectedFormat = "includeAttributes=false&includeChildren=true&" . $vocabularyAndAtrributes;
		$result = $this->mds->mdsQueryString($vocabularyAndAtrributes, "false", "true");
		$this->assertStringMatchesFormat($expectedFormat, $result);
	}
	/**
	 * testMdsQueryStringGetElementWithChildrenAndAttributes
	 *
	 */
	public function testMdsQueryStringGetElementWithChildrenAndAttributes() {
		$mds = $this->mds;
		$vocabularyAndAtrributes = $this->vocabularyAndAtrributes;
		$expectedFormat = "includeAttributes=true&includeChildren=true&" . $vocabularyAndAtrributes;
		$result = $this->mds->mdsQueryString($vocabularyAndAtrributes, "true", "true");
		$this->assertStringMatchesFormat($expectedFormat, $result);
	}
	/**
	 * testMdsQueryStringFourParamAttribFalse
	 *
	 */
	public function testMdsQueryStringGetElementNoAttributesNoChildren() {
		$mds = $this->mds;
		$vocabulary = $this->vocabulary;
		$queryParams = $this->queryParams;
		$expectedFormat = "includeAttributes=false&includeChildren=false&vocabularyName=" . $vocabulary . $queryParams;
		$result = $this->mds->mdsQueryString($queryParams, "false", "false", $vocabulary);
		$this->assertStringMatchesFormat($expectedFormat, $result);
	 }
	/**
	 * testMdsQueryStringGetElementNoAttributesWithChildren
	 *
	 */
	public function testMdsQueryStringGetElementNoAttributesWithChildren() {
		$mds = $this->mds;
		$vocabulary = $this->vocabulary;
		$queryParams = $this->queryParams;
		$expectedFormat = "includeAttributes=false&includeChildren=true&vocabularyName=" . $vocabulary . $queryParams;
		$result = $this->mds->mdsQueryString($queryParams, "false", "true", $vocabulary);
		$this->assertStringMatchesFormat($expectedFormat, $result);
	}
	/**
	 * testMdsQueryStringGetElementWithAttributesNoChildren
	 *
	 */
	public function testMdsQueryStringGetElementWithAttributesNoChildren() {
		$mds = $this->mds;
		$vocabulary = $this->vocabulary;
		$queryParams = $this->queryParams;
		$expectedFormat = "includeAttributes=true&includeChildren=true&vocabularyName=" . $vocabulary . $queryParams;
		$result = $this->mds->mdsQueryString($queryParams, "true", "true", $vocabulary);
		$this->assertStringMatchesFormat($expectedFormat, $result);
	}
	/**
	 * testGnsSoupQuery
	 *
	 * @return bool
	 */
	public function testGnsSoupQuery() {
		$gnsSoupQuery = "/gnsoup?";
		$param1;
		$this->configureStub();
		$this->curl->expects( $this->any() )
		->method( 'setOption' )
		->with( $this->callback( function( $arg ) use ( &$param1 ) {
					$param1 = $arg;
					return true;
				} ),
			$this->callback( function( $arg ) use ( &$param1 ) {
					//echo "HB | $param1 | ". $xml . " |\n";
					//print_r( $arg );

					if ( $param1 == CURLOPT_USERPWD ) {
						$usr = Yii::app()->params->gns['username'];
						$pass = Yii::app()->params->gns['password'];
						$this->assertEquals( $usr . ':' . $pass, $arg );
					}
					return true;
				} ) )
		->will( $this->returnValue( true ) );

		$mds = $this->mds;
		$mds->setCurlResource( $this->curl );

		$result = $mds->gnsSoupQuery( $gnsSoupQuery );

		//var_dump($result);


		$this->assertNotNull( $result );

	}

}
