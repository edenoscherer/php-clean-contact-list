CREATE TABLE IF NOT EXISTS public.people (
    id serial NOT NULL,
    name varchar(255) NOT NULL,
    created_at timestamp(0) NULL,
    updated_at timestamp(0) NULL,
    CONSTRAINT people_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.contacts (
    id serial NOT NULL,
    id_person serial NOT NULL,
    type varchar(255) NOT NULL,
    value varchar(255) NOT NULL,
    created_at timestamp(0) NULL,
    updated_at timestamp(0) NULL,
    CONSTRAINT contacts_pkey PRIMARY KEY (id),
	CONSTRAINT contacts_fk FOREIGN KEY (id_person) REFERENCES public.people(id) ON DELETE CASCADE ON UPDATE CASCADE
);
