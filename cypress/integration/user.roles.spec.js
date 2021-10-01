/// <reference types="Cypress" />

const NEW_TAB_REL_DEFAULT_VALUE = 'noreferrer noopener';

// user should be allowed to access these pages
// defaults for "GC Editor"
const allowedPages200 = [
    'index.php',
    'edit.php',
    'post-new.php',
    'edit.php?post_type=page',
    'post-new.php?post_type=page',
    'admin.php?page=cds_notify_send'
];

// user should not be able to access these pages
// defaults for "GC Editor"
const blockedPages403 = [
    'upload.php',
    'themes.php',
    'options-general.php'
];

const blockedPages500 = [
    'user-edit.php?user_id=1',
];



const checkPages = (pages, status) => {
    pages.forEach((page) => {
        cy.request({
            url: `wp-admin/${page}`,
            failOnStatusCode: false
        }).should((response) => {
            expect(response.status).to.eq(status);
        })
    });
}

describe('User - GC Editor', () => {
    before(() => {

    });

    after(() => {
        cy.exec('npm run wp-env:clean');
    });

    it('GC Editor login & page access', () => {
        cy.addUser('gceditor', 'secret', 'GC Editor');
        cy.loginUser('gceditor', 'secret');
        checkPages(allowedPages200, 200);
        checkPages([...blockedPages403, 'users.php'], 403);
        checkPages(blockedPages500, 500);
    });

});

describe('User - GC Admin', () => {
    before(() => {

    });

    after(() => {
        cy.exec('npm run wp-env:clean');
    });

    it('GC Admin login & page access', () => {
        cy.addUser('gcadmin', 'secret', 'GC Admin');
        cy.loginUser('gcadmin', 'secret');
        checkPages([...allowedPages200, 'users.php'], 200);
        checkPages(blockedPages403, 403);
    });
});