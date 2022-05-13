package shopify

import "testing"

func TestShopify(t *testing.T) {
	if Shopify() != "lettuce turnip the beets" {
		t.Fatalf("Shopify does not say 'lettuce turnip the beets'")
	}
}
