<?php

namespace App\Core;

class Validator
{
    private array $data;
    private array $errors = [];
    private array $rules = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data, array $rules): self
    {
        $validator = new self($data);
        $validator->rules = $rules;
        $validator->validate();
        return $validator;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $ruleList = is_string($rules) ? explode('|', $rules) : $rules;

            foreach ($ruleList as $rule) {
                $this->applyRule($field, $rule);
            }
        }

        return empty($this->errors);
    }

    private function applyRule(string $field, string $rule): void
    {
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $parameter = $parts[1] ?? null;

        $value = $this->data[$field] ?? null;

        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, "Le champ {$field} est requis.");
                }
                break;

            case 'email':
                if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Le champ {$field} doit être une adresse email valide.");
                }
                break;

            case 'min':
                if ($value && strlen($value) < (int)$parameter) {
                    $this->addError($field, "Le champ {$field} doit contenir au moins {$parameter} caractères.");
                }
                break;

            case 'max':
                if ($value && strlen($value) > (int)$parameter) {
                    $this->addError($field, "Le champ {$field} ne doit pas dépasser {$parameter} caractères.");
                }
                break;

            case 'numeric':
                if ($value && !is_numeric($value)) {
                    $this->addError($field, "Le champ {$field} doit être un nombre.");
                }
                break;

            case 'integer':
                if ($value && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, "Le champ {$field} doit être un entier.");
                }
                break;

            case 'string':
                if ($value && !is_string($value)) {
                    $this->addError($field, "Le champ {$field} doit être une chaîne de caractères.");
                }
                break;

            case 'in':
                $allowedValues = explode(',', $parameter);
                if ($value && !in_array($value, $allowedValues)) {
                    $this->addError($field, "Le champ {$field} doit être l'une des valeurs suivantes : " . implode(', ', $allowedValues));
                }
                break;

            case 'unique':
                // Pour la validation unique, nécessite une connexion DB
                // On laisse cette règle pour extension future
                break;

            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if ($value !== ($this->data[$confirmField] ?? null)) {
                    $this->addError($field, "Le champ {$field} et sa confirmation ne correspondent pas.");
                }
                break;

            case 'regex':
                if ($value && !preg_match($parameter, $value)) {
                    $this->addError($field, "Le champ {$field} n'a pas le format attendu.");
                }
                break;

            case 'url':
                if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "Le champ {$field} doit être une URL valide.");
                }
                break;

            case 'date':
                if ($value && !strtotime($value)) {
                    $this->addError($field, "Le champ {$field} doit être une date valide.");
                }
                break;

            case 'alpha':
                if ($value && !preg_match('/^[a-zA-Z]+$/', $value)) {
                    $this->addError($field, "Le champ {$field} ne doit contenir que des lettres.");
                }
                break;

            case 'alphanumeric':
                if ($value && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                    $this->addError($field, "Le champ {$field} ne doit contenir que des lettres et des chiffres.");
                }
                break;

            case 'between':
                $range = explode(',', $parameter);
                if ($value && (strlen($value) < (int)$range[0] || strlen($value) > (int)$range[1])) {
                    $this->addError($field, "Le champ {$field} doit contenir entre {$range[0]} et {$range[1]} caractères.");
                }
                break;

            case 'array':
                if ($value && !is_array($value)) {
                    $this->addError($field, "Le champ {$field} doit être un tableau.");
                }
                break;

            case 'boolean':
                if ($value !== null && !is_bool($value) && !in_array($value, [0, 1, '0', '1', true, false], true)) {
                    $this->addError($field, "Le champ {$field} doit être un booléen.");
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validated(): array
    {
        if ($this->fails()) {
            throw new \Exception('Validation failed');
        }

        $validated = [];
        foreach (array_keys($this->rules) as $field) {
            if (isset($this->data[$field])) {
                $validated[$field] = $this->data[$field];
            }
        }

        return $validated;
    }
}
