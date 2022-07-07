<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models;

use stdClass;
use Illuminate\Database\Eloquent\Model;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\ContactEntity;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models\PeopleModel;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 *
 * @property int $id
 * @property int $id_person
 * @property string $type
 * @property string $value
 *
 * @property-read PeopleModel $person
 */
final class ContactsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_person',
        'type',
        'value',
    ];

    /**
     * @return PeopleModel|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(PeopleModel::class, 'id_person', 'id');
    }

    /**
     * @return ContactEntity
     */
    public function createContactEntity(): ContactEntity
    {
        $params = new stdClass();
        $params->id = $this->id;
        $params->idPerson = $this->id_person;
        $params->type = $this->type;
        $params->value = $this->value;
        return new ContactEntity($params);
    }
}
