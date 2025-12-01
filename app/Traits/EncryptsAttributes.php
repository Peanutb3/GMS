<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait EncryptsAttributes
{
    /**
     * Get the encrypted attributes for this model.
     *
     * @return array
     */
    public function getEncryptedAttributes()
    {
        return property_exists($this, 'encrypted') ? $this->encrypted : [];
    }

    /**
     * Get an attribute from the model with automatic decryption.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->getEncryptedAttributes()) && !is_null($value)) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                // If decryption fails, return original value
                // This handles cases where data is not yet encrypted
                return $value;
            }
        }

        return $value;
    }

    /**
     * Set an attribute on the model with automatic encryption.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncryptedAttributes()) && !is_null($value)) {
            try {
                // Check if already encrypted
                Crypt::decryptString($value);
                // If no exception, it's already encrypted
                return parent::setAttribute($key, $value);
            } catch (\Exception $e) {
                // Not encrypted, encrypt it
                $value = Crypt::encryptString($value);
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get the attributes that should be converted to native types.
     * Override to prevent casting conflicts with encrypted data.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getEncryptedAttributes() as $key) {
            if (isset($attributes[$key])) {
                try {
                    $attributes[$key] = Crypt::decryptString($attributes[$key]);
                } catch (\Exception $e) {
                    // Keep original if decryption fails
                }
            }
        }

        return $attributes;
    }
}
