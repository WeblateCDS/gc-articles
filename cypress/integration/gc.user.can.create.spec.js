/// <reference types="Cypress" />

const NEW_TAB_REL_DEFAULT_VALUE = 'noreferrer noopener';

describe('User - GC Editor', () => {
    before(() => {

    });

    after(() => {
        cy.exec('npm run wp-env:clean');
    });

    it('GC Admin can add GC Editors', () => {
        cy.addUser('gcadmin', 'secret', 'GC Admin');
        cy.loginUser('gcadmin', 'secret');
        // try adding a GC Editor using GC Admin account
        cy.addUser('gceditor', 'secret', 'GC Editor', false);
    });

});