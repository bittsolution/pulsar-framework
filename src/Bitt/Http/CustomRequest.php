<?php

namespace Bitt\Http;

abstract class CustomRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    public function validate()
    {
        $rules = $this->rules();
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $this->request->body->get($field);

            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && ($value === null || $value === '')) {
                    $errors[$field][] = 'The ' . $field . ' field is required.';
                }
            }
        }

        if (!empty($errors)) {
            throw new \Exception('Validation failed: ' . json_encode($errors));
        }

        return true;
    }

    abstract public function rules(): array;

    abstract public function authorize(): bool;

    protected function input(string $key, $default = null)
    {
        return $this->request->body->get($key, $default);
    }
}
