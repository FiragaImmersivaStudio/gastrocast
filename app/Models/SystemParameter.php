<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get the typed value of the parameter
     */
    public function getTypedValueAttribute()
    {
        switch ($this->type) {
            case 'boolean':
                return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $this->value;
            case 'json':
                return json_decode($this->value, true);
            default:
                return $this->value;
        }
    }

    /**
     * Set the value with proper type conversion
     */
    public function setTypedValue($value, $type = null)
    {
        if ($type) {
            $this->type = $type;
        }

        switch ($this->type) {
            case 'boolean':
                $this->value = $value ? 'true' : 'false';
                break;
            case 'integer':
                $this->value = (string) (int) $value;
                break;
            case 'json':
                $this->value = json_encode($value);
                break;
            default:
                $this->value = (string) $value;
        }
    }

    /**
     * Get a system parameter value by key
     */
    public static function getValue($key, $default = null)
    {
        $param = static::where('key', $key)->first();
        return $param ? $param->typed_value : $default;
    }

    /**
     * Set a system parameter value
     */
    public static function setValue($key, $value, $type = 'string', $description = null)
    {
        $param = static::firstOrNew(['key' => $key]);
        $param->setTypedValue($value, $type);
        if ($description) {
            $param->description = $description;
        }
        $param->save();
        return $param;
    }
}
