<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models;

use stdClass;
use Illuminate\Database\Eloquent\Model;
use Edeno\PhpCleanContactList\Contacts\Domain\Entities\PersonEntity;
use Edeno\PhpCleanContactList\Contacts\Infra\Database\Eloquent\Models\ContactsModel;

/**
 * @author Edeno Luiz Scherer <edenoshcerer@gmail.com>
 *
 * @property int $id
 * @property string $name
 *
 * @property-read ContactsModel[]|\Illuminate\Database\Eloquent\Collection $contacts
 */
final class PeopleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people';
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
        'name',
    ];

    /**
     * @return ContactsModel[]|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(ContactsModel::class, 'id_person', 'id');
    }

    /**
     * @return PersonEntity
     */
    public function createPersonEntity(): PersonEntity
    {
        $params = new stdClass();
        $params->id = $this->id;
        $params->name = $this->name;
        $contacts = [];
        foreach ($this->contacts as $contact) {
            $contacts[] = $contact->createContactEntity();
        }
        $params->contacts = $contacts;
        return new PersonEntity($params);
    }
}
