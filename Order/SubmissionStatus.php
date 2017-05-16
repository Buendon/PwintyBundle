<?php

namespace Buendon\PwintyBundle\Order;


class SubmissionStatus
{
    const FIELD_ID = "id";
    const FIELD_IS_VALID = "isValid";
    const FIELD_PHOTOS = "photos";
    const FIELD_GENERAL_ERRORS = "generalErrors";

    const GENERAL_ERRORS_ACCOUNT_BALANCE_INSUFFICIENT = "AccountBalanceInsufficient";
    const GENERAL_ERRORS_ITEMS_CONTAINING_ERRORS = "ItemsContainingErrors";
    const GENERAL_ERRORS_NO_ITEMS_IN_ORDER = "NoItemsInOrder";
    const GENERAL_ERRORS_POSTAL_ADDRESS_NOT_SET = "PostalAddressNotSet";

    /**
     * @var string
     */
    private $id;
    /**
     * @var bool
     */
    private $isValid;
    /**
     * @see PhotoError
     * @var array
     */
    private $photos;
    /**
     * @var array
     */
    private $generalErrors;

    /**
     * Expect an array with the different fields keys.
     * @param array
     */
    public function __construct($data)
    {
        $this->id = $data[SubmissionStatus::FIELD_ID];
        $this->isValid = boolval($data[SubmissionStatus::FIELD_IS_VALID]);
        if(array_key_exists(SubmissionStatus::FIELD_PHOTOS, $data)) {
            $jsonPhotoErrors = $data[SubmissionStatus::FIELD_PHOTOS];
            $photoErrors = array();
            foreach ($jsonPhotoErrors as $jsonPhotoError) {
                array_push($photoErrors, new PhotoError($jsonPhotoError));
            }
            $this->photos = $photoErrors;
        }
        if(array_key_exists(SubmissionStatus::FIELD_GENERAL_ERRORS, $data)) {
            $this->generalErrors  = $data[SubmissionStatus::FIELD_GENERAL_ERRORS];
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
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @return array
     */
    public function getGeneralErrors(): array
    {
        return $this->generalErrors;
    }
}