<?php

namespace Jackalope\NodeType;

use Jackalope\TestCase;

class NodeTypeXmlConverterDefinitionTest extends TestCase
{
    private $converter;

    public function setUp()
    {
        $this->converter = new NodeTypeXmlConverter();
    }

    public function testConvertNtBase()
    {
        $data = $this->converter->getNodeTypeDefinitionFromXml($this->getNodeTypeDOMElement('nt:base'));

        $this->assertEquals(array(
            'name' => 'nt:base',
            'isAbstract' => true,
            'isMixin' => false,
            'isQueryable' => true,
            'hasOrderableChildNodes' => true,
            'primaryItemName' => NULL,
            'declaredSuperTypeNames' => array(),
            'declaredPropertyDefinitions' => array(
                array(
                    'declaringNodeType' => '',
                    'name' => 'jcr:primaryType',
                    'isAutoCreated' => true,
                    'isMandatory' => true,
                    'isProtected' => true,
                    'onParentVersion' => 4,
                    'requiredType' => 7,
                    'isMultiple' => true,
                    'isFullTextSearchable' => true,
                    'isQueryOrderable' => true,
                ), array(
                    'declaringNodeType' => '',
                    'name' => 'jcr:mixinTypes',
                    'isAutoCreated' => true,
                    'isMandatory' => true,
                    'isProtected' => true,
                    'onParentVersion' => 4,
                    'requiredType' => 7,
                    'isMultiple' => true,
                    'isFullTextSearchable' => true,
                    'isQueryOrderable' => true,
                ),
            ),
            'declaredNodeDefinitions' => array(),
        ), $data);
    }

    public function testConvertNtUnstructured()
    {
        $data = $this->converter->getNodeTypeDefinitionFromXml($this->getNodeTypeDOMElement('nt:unstructured'));

        $this->assertEquals(array(
            'name' => 'nt:unstructured',
            'isAbstract' => false,
            'isMixin' => false,
            'isQueryable' => true,
            'hasOrderableChildNodes' => true,
            'primaryItemName' => NULL,
            'declaredSuperTypeNames' => array('nt:base'),
            'declaredPropertyDefinitions' => array(
                array(
                    'declaringNodeType' => 'nt:unstructured',
                    'name' => '*',
                    'isAutoCreated' => true,
                    'isMandatory' => false,
                    'isProtected' => true,
                    'onParentVersion' => 1,
                    'requiredType' => 0,
                    'isMultiple' => true,
                    'isFullTextSearchable' => true,
                    'isQueryOrderable' => true,
                ),
            ),
            'declaredNodeDefinitions' => array(
                array(
                    'declaringNodeType' => 'nt:unstructured',
                    'name' => '*',
                    'isAutoCreated' => true,
                    'isMandatory' => false,
                    'isProtected' => true,
                    'onParentVersion' => 2,
                    'allowsSameNameSiblings' => false,
                    'defaultPrimaryTypeName' => 'nt:unstructured',
                    'requiredPrimaryTypeNames' => 'nt:base',
                ),
        )), $data);
    }

    public function getNodeTypeDOMElement($name)
    {
        $xml = <<<XML
<nodeTypes>
    <nodeType name="nt:base" isMixin="false" isAbstract="true">
        <propertyDefinition name="jcr:primaryType" requiredType="NAME" autoCreated="true" mandatory="true" protected="true" onParentVersion="COMPUTE" />
        <propertyDefinition name="jcr:mixinTypes" requiredType="NAME" autoCreated="true" mandatory="true" protected="true" multiple="true" onParentVersion="COMPUTE" />
    </nodeType>
    <nodeType name="nt:unstructured" hasOrderableChildNodes="true" isMixin="false" isAbstract="false">
        <supertypes>
            <supertype>nt:base</supertype>
        </supertypes>
        <childNodeDefinition autoCreated="false" declaringNodeType="nt:unstructured" defaultPrimaryType="nt:unstructured" mandatory="false" name="*" onParentVersion="VERSION" protected="false" sameNameSiblings="false">
          <requiredPrimaryTypes>
            <requiredPrimaryType>nt:base</requiredPrimaryType>
          </requiredPrimaryTypes>
        </childNodeDefinition>
        <propertyDefinition autoCreated="false" declaringNodeType="nt:unstructured" fullTextSearchable="true" mandatory="false" multiple="true" name="*" onParentVersion="COPY" protected="false" queryOrderable="true" requiredType="undefined" />
    </nodeType>
    <nodeType name="mix:etag" isMixin="true">
        <propertyDefinition name="jcr:etag" requiredType="STRING" autoCreated="true" protected="true" onParentVersion="COMPUTE" />
    </nodeType>
    <nodeType name="nt:hierachy" isAbstract="true">
        <supertypes>
            <supertype>mix:created</supertype>
        </supertypes>
    </nodeType>
    <nodeType name="nt:file" isMixin="false" isAbstract="false">
        <supertypes>
            <supertype>nt:hierachy</supertype>
        </supertypes>
    </nodeType>
    <nodeType name="nt:folder" isMixin="false" isAbstract="false">
        <supertypes>
            <supertype>nt:hierachy</supertype>
        </supertypes>
    </nodeType>
    <nodeType name="nt:resource" isMixin="false" isAbstract="false" primaryItemName="jcr:data">
        <supertypes>
            <supertype>mix:mimeType</supertype>
            <supertype>mix:modified</supertype>
        </supertypes>
        <propertyDefinition name="jcr:created" requiredType="BINARY" autoCreated="false" protected="false" onParentVersion="COPY" />
    </nodeType>
    <nodeType name="mix:created" isMixin="true">
        <propertyDefinition name="jcr:created" requiredType="DATE" autoCreated="true" protected="true" onParentVersion="COMPUTE" />
        <propertyDefinition name="jcr:createdBy" requiredType="STRING" autoCreated="true" protected="true" onParentVersion="COMPUTE" />
    </nodeType>
    <nodeType name="mix:mimeType" isMixin="true">
        <propertyDefinition name="jcr:mimeType" requiredType="DATE" autoCreated="false" protected="true" onParentVersion="COPY" />
        <propertyDefinition name="jcr:encoding" requiredType="STRING" autoCreated="false" protected="true" onParentVersion="COPY" />
    </nodeType>
    <nodeType name="mix:lastModified" isMixin="true">
        <propertyDefinition name="jcr:lastModified" requiredType="DATE" autoCreated="true" protected="true" onParentVersion="COMPUTE" />
        <propertyDefinition name="jcr:lastModifiedBy" requiredType="STRING" autoCreated="true" protected="true" onParentVersion="COMPUTE" />
    </nodeType>
</nodeTypes>

XML;
          $dom = new \DOMDocument('1.0', 'UTF-8');
          $dom->loadXML($xml);

          $xpath = new \DOMXpath($dom);
          $nodes = $xpath->evaluate('//nodeTypes/nodeType[@name="'.$name.'"]');
          if ($nodes->length != 1) {
              $this->fail("Should have found exactly one element <nodeType> with name " . $name);
          }
          return $nodes->item(0);
    }
}