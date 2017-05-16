<?php

namespace Buendon\PwintyBundle\Order;


class PhotoError
{
    const FIELD_ID = "id";
    const FIELD_ERRORS = "errors";
    const FIELD_WARNINGS = "warnings";

    const ERROR_FILE_COULD_NOT_BE_DOWNLOADED = "FileCouldNotBeDownloaded";
    const ERROR_NO_IMAGE_FILE = "NoImageFile";
    const ERROR_INVALID_IMAGE_FILE = "InvalidImageFile";
    const ERROR_POSTAL_ADDRESS_NOT_SET = "PostalAddressNotSet";

    const WARNING_CROPPING_WILL_OCCUR = "CroppingWillOccur";
    const WARNING_PICTURE_SIZE_TOO_SMALL = "PictureSizeTooSmall";
    const WARNING_COULD_NOT_VALIDATE_IMAGE_SIZE = "CouldNotValidateImageSize";
    const WARNING_COULD_NOT_VALIDATE_ASPECT_RATIO = "CouldNotValidateAspectRatio";

    /**
     * @var string
     */
    private $id;
    /**
     * @var array
     */
    private $errors = array();
    /**
     * @var array
     */
    private $warnings = array();

    /**
     * Expect an array with the different fields keys.
     * @param array
     */
    public function __construct($data)
    {
        $this->id = $data[PhotoError::FIELD_ID];
        if(array_key_exists(PhotoError::FIELD_ERRORS, $data)) {
            $this->errors = $data[PhotoError::FIELD_ERRORS];
        }
        if(array_key_exists(PhotoError::FIELD_WARNINGS, $data)) {
            $this->warnings = $data[PhotoError::FIELD_WARNINGS];
        }
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}