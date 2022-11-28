<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use InvalidArgumentException;

class AttachmentString extends Attachment
{
    private ?string $fileString = Null;
    private string $baseName;

    /**
     * @return string
     */
    public function getFileString(): ?string
    {
        return $this->fileString;
    }

    /**
     * @param string $fileString
     * @return AttachmentString
     */
    public function setFileString(string $fileString): AttachmentString
    {
        $this->fileString = $fileString;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * @param string $baseName
     * @return AttachmentString
     */
    public function setBaseName(string $baseName): AttachmentString
    {
        $this->baseName = $baseName;
        return $this;
    }

    /**
     * The validate function that is called during xml writing to valid the data of the object.
     *
     * @throws InvalidArgumentException An error with information about required data that is missing to write the XML
     * @return void
     */
    public function validate()
    {
        if ($this->fileString === null) {
            throw new InvalidArgumentException('Missing fileString');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $fileContents = base64_encode($this->fileString);

        $writer->write([
            'name' => Schema::CBC . 'EmbeddedDocumentBinaryObject',
            'value' => $fileContents,
            'attributes' => [
                'mimeCode' => 'application/pdf',
                'filename' => $this->baseName
            ]
        ]);
    }
}
