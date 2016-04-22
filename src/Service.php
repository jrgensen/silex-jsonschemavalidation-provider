<?php
namespace JsonSchemaValidation;

class Service
{
    protected $schemafilepath;

    public function __construct($schemafilepath)
    {
        $this->schemafilepath = $schemafilepath;
    }

    public function validate(\stdClass $json)
    {
        $retriever = new \JsonSchema\Uri\UriRetriever;
        $validator = new \JsonSchema\Validator();

        $resource = $this->schemafilepath;
        if (strpos($resource, ':') === false  && file_exists($resource)) {
            $resource = "file://$resource";
        }
        $validator->check($json, $retriever->retrieve($resource));

        if (!$validator->isValid()) {
            throw new ValidationException('JSON does not validate', $validator);
        }
        return true;
    }
}
