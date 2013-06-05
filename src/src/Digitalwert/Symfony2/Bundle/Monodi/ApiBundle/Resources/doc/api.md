### `OPTIONS` /api/v1/documents/ ###



### `POST` /api/v1/documents/ ###

_Legt ein neues Dokument an_

Legt ein neues Dokument an


### `DELETE` /api/v1/documents/{id} ###

_Löscht das angegeben Dokument_

Löscht das angegeben Dokument

#### Requirements ####

**id**



### `GET` /api/v1/documents/{id}.{_format} ###

_Gibt ein Dokument zurück_

Gibt ein Dokument zurück

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**id**



### `PUT` /api/v1/documents/{id}.{_format} ###

_Aktualisiert ein Dokument_

Aktualisiert ein Dokument

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**id**


#### Parameters ####

document[title]:

  * type: string
  * required: true

document[content]:

  * type: string
  * required: true


### `GET` /api/v1/metadata.{_format} ###

_Gibt Metainforamtion zu Root zurück_

Gibt Metainforamtion zu Root zurück

#### Requirements ####

**_format**

  - Requirement: (xml|json)


### `GET` /api/v1/metadata/{path}.{_format} ###

_Gibt Metainforamtion zu Verzeichnien oder Dateien zurück_

Gibt Metainforamtion zu Verzeichnien oder Dateien zurück

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**path**

  - Requirement: [a-z_-\d\/]+


### `GET` /api/v1/profile/{slug}.{_format} ###

_Gibt ein einzelnes Profile zurück_

Gibt ein einzelnes Profile zurück

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**slug**

  - Requirement: [a-z_-\d]+


### `PUT` /api/v1/profile/{slug}.{_format} ###

_Aktualisiert ein Profil_

Aktualisiert ein Profil

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**slug**

  - Requirement: [a-z_-\d]+
  - Type: string

#### Parameters ####

profile[email]:

  * type: string
  * required: true
  * description: Nutzer-Email

profile[lastname]:

  * type: string
  * required: true

profile[firstname]:

  * type: string
  * required: true

profile[title]:

  * type: string
  * required: false

profile[salutation]:

  * type: string
  * required: true


### `PUT` /api/v1/profile/{slug}/password.{_format} ###

_Ändert das Password eines Nutzers_

Ändert das Password eines Nutzers

#### Requirements ####

**_format**

  - Requirement: (xml|json)
**slug**

  - Requirement: [a-z_-\d]+
  - Type: string

#### Parameters ####

password[current_password]:

  * type: string
  * required: true
  * description: form.current_password

password[new]:

  * type: string
  * required: true
  * description: form.new_password
