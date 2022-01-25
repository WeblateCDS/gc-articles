<?php

declare(strict_types=1);

namespace CDS\Modules\Cleanup;

class SitesToCollections
{
    public string $adminEmailMessage;
    public string $collectionMessage;

    public function __construct()
    {
        $this->adminEmailMessage = __('Admin Email <strong>must be</strong> a current Super Admin', 'cds-snc');
        $this->collectionMessage = __('or else a Collection won’t be created', 'cds-snc');

        // add message to the Add New Collection Form
        add_action('network_site_new_form', [$this, 'editNewCollectionForm']);
        // throw an error if a new user is attepted to be created when adding a New Collection
        add_action('pre_network_site_new_created_user', [$this, 'dieIfNewUser']);
    }

    public function editNewCollectionForm(): void
    {
        // remove the existing message
        print "<style>.form-field:last-of-type {display: none;}</style>";
        printf(
            "<p>%s, %s.</p>",
            $this->adminEmailMessage,
            $this->collectionMessage
        );
    }

    public function dieIfNewUser(): void
    {
        wp_die($this->adminEmailMessage . '.');
    }
}
