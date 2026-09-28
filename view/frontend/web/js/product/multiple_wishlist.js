define([
    'uiComponent',
    'ko',
    'mage/url',
    'mage/storage',
    'Magento_Ui/js/modal/alert'
], function (
    Component,
    ko,
    urlBuilder,
    storage,
    alert
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'BrunoDuarte_MultipleWishlist/product/view'
        },

        productId: null,
        addUrl: null,

        initialize: function(config) {
            this._super();

            this.productId          = config.productId;
            this.addUrl             = config.addUrl;
            this.wishlists          = ko.observableArray([]);
            this.selectedWishlistId = ko.observable('');
            this.isLoading          = ko.observable(false);
            this.successMessage     = ko.observable('');
            this.errorMessage       = ko.observable('');
            this.buttonLabel        = ko.observable('Adicionar à Lista de Desejo');
            this.canAdd             = ko.computed(function() {
                return !!this.selectedWishlistId() && !this.loadWishlists();
            });

            this.loadWishlists();

            return this;
        },

        loadWishlists: function() {
            var self = this;

            storage.get(
                urlBuilder.build('multiple_wishlist/ajax/getListOptionsSelectField')
            ).done(function(response) {
                if (response.success) {
                    self.wishlists(response.wishlists)
                }
            }).fail(function() {
                self.errorMessage('Não foi possível carregar suas listas.');
            });
        },

        canAdd: function() {
            return (this.selectedWishlistId() && !this.isLoading());
        },

        addToWishlist: function() {
            // adiciona o produto na lista de desejo.
        }
    });
});
