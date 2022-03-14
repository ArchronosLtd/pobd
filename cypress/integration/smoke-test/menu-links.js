describe('Menu links working', () => {
  function cfHeaderHit(res) {
    const headers = res.headers;
      expect(headers['cf-cache-status']).to.equal('HIT');
  }

  it('should open all pages', () => {
    cy.visit('https://www.parishofbasingstokedown.org.uk/');
    cy.request('/').then(cfHeaderHit);
    cy.get('#cookie-overlay').should('be.visible')
      .get('#cookie-banner').should('be.visible')
      .get('[data-testid="agree-cookie"]').click()
      .get('#cookie-overlay').should('not.be.visible')
      .get('#cookie-banner').should('not.be.visible')
      .get('[data-testid="agree-cookie"]')
    cy.request('about-us/').then(cfHeaderHit);
    cy.request('about-us/our-team/').then(cfHeaderHit)
    cy.request('church-life/home-groups/').then(cfHeaderHit)
    cy.request('about-us/churches/').then(cfHeaderHit)
    cy.request('locations/immanuel-church/').then(cfHeaderHit)
    cy.request('social-life/tea2/').then(cfHeaderHit)
    cy.request('social-life/smak/').then(cfHeaderHit)
    cy.request('social-life/oasis/').then(cfHeaderHit)
    cy.request('social-life/create-n-cuppa/').then(cfHeaderHit)
    cy.request('social-life/chat-n-play/').then(cfHeaderHit)
    cy.request('social-life/little-angels/').then(cfHeaderHit)
    cy.request('church-life/home-groups-2/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/open-the-book/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/gods-gifts/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/the-grid/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/the-message/').then(cfHeaderHit)
    cy.request('church-life/children-and-youth/the-zone/').then(cfHeaderHit)
    cy.request('church-life/cap-money-course/').then(cfHeaderHit)
    cy.request('church-life/mission/').then(cfHeaderHit)
    cy.request('church-life/music-group/').then(cfHeaderHit)
    cy.request('services/').then(cfHeaderHit)
    cy.request('services/sunday-services/').then(cfHeaderHit)
    cy.request('services/sunday-services/sermons/').then(cfHeaderHit)
    cy.request('services/baptisms/').then(cfHeaderHit)
    cy.request('services/confirmation/').then(cfHeaderHit)
    cy.request('services/weddings/').then(cfHeaderHit)
    cy.request('services/funerals/').then(cfHeaderHit)
    cy.request('new-here/').then(cfHeaderHit)
    cy.request('contact/').then(cfHeaderHit)
    cy.request('giving/').then(cfHeaderHit)
    cy.request('hire/').then(cfHeaderHit)
    cy.request('plan-your-visit/').then(cfHeaderHit)
    cy.request('policies/safeguarding/').then(cfHeaderHit)
    cy.request('policies/privacy-policy-2/').then(cfHeaderHit)
  });
});