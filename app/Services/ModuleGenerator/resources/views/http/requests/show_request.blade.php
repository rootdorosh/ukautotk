<?php 
use Illuminate\Support\Str;
?>

declare( strict_types = 1 );

namespace App\Modules\{{ $moduleName }}\Http\Requests\{{ $model['name'] }};

use App\Base\Requests\BaseShowRequest;

/**
 * Class ShowRequest
 */
class ShowRequest extends BaseShowRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('{{ strtolower($moduleName) }}.{{ strtolower($model['name']) }}.show');
    }
}
