<?php

/**
 * Controller for displaying the xml feed.
 *
 * <code>
 * http://site.com/shoppingfeed.xml
 * </code>
 *
 * @package googlesitemaps
 */
class GoogleShoppingFeedController extends Controller
{

    /**
     * @var array
     */
    private static $allowed_actions = array(
        'index'
    );
    
    /**
     * Specific controller action for displaying a particular list of links 
     * for a class
     * 
     * @return mixed
     */
    public function index()
    {
        Config::inst()->update('SSViewer', 'set_source_file_comments', false);
        
        $this->getResponse()->addHeader(
            'Content-Type',
            'application/xml; charset="utf-8"'
        );
        $this->getResponse()->addHeader(
            'X-Robots-Tag',
            'noindex'
        );

        $currency = EcommerceCurrency::default_currency_code();

        return [
            "SiteConfig" => SiteConfig::current_site_config(),
            'Items' => $this->getItems(),
            "Currency" => $currency
        ];
    }

    public function getItems()
    {
        $output = new ArrayList();

        $products = Product::get()->filter(['HideFromShoppingFeed' => false]);

        foreach ($products as $product) {
            $output->push($product);
        }

        return $output;
    }   

}
