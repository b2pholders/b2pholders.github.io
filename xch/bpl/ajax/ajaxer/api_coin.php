<?php

namespace BPL\Ajax\Ajaxer\API_Coin;

require_once 'bpl/ajax/ajaxer/jquery_number.php';
require_once 'bpl/mods/helpers.php';

use function BPL\Ajax\Ajaxer\Jquery_Number\main as jquery_number;
use function BPL\Mods\Helpers\settings;

/**
 * @return string
 *
 * @since version
 */
function main(): string
{
	$currency = settings('ancillaries')->currency;
//	$fmc_to_usd = settings('trading')->fmc_to_usd;

	$str = '<script>';

	if ($currency === 'PHP')
	{
		$str .= '(function ($) {
            function updatePrice(fmc) {
                $("#rate_sell, #rate_buy, #fmc_mkt_price_online").html($.number(fmc, 5));
            }

            function fetchPrice() {
                $.ajax({
                    url: "https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=php",
                    timeout: 5000, // Set a timeout to avoid hanging
                    success: function (data) {
                        const fmc = data.tether.php;
                        updatePrice(fmc);
                    },
                    error: function () {
                        console.error("Error fetching price. Falling back to default value.");
                        const fallbackPrice = 0.012; // More meaningful fallback
                        updatePrice(fallbackPrice);
                    }
                });
            }

            // Fetch the price initially and then every 30 seconds
            fetchPrice();
            setInterval(fetchPrice, 30000);
        })(jQuery);';
	}
	elseif (in_array($currency, ['B2P', 'BTC3', 'BTCB', 'BTCW', 'GOLD', 'PAC', 'P2P', 'LTC', 'AET', 'TPAY', 'PESO']))
	{ // coinbrain
		$str .= '(function ($) {
		    function updatePrice(fmc) {
		        $("#rate_sell, #rate_buy, #fmc_mkt_price_online").html($.number(fmc, 5));
		    }
		
		    function fetchPrice(token) {
		        let contract = "";
		        switch (token) {
		            case "B2P":
						contract = "0xF8AB9fF465C612D5bE6A56716AdF95c52f8Bc72d";
						break;
					case "BTC3":
						contract = "0xbea17f143f2535f424c9d7acd5fbff75a9c8ab62";
						break;
					case "BTCB":
						contract = "0x7130d2A12B9BCbFAe4f2634d864A1Ee1Ce3Ead9c";
						break;
					case "BTCW":
						contract = "0xfc4f8cDC508077e7a60942e812A9C9f1f05020c5";
						break;
					case "GOLD":
						contract = "0x4A0bfC65fEb6F477E3944906Fb09652d2d8b5f0d";
						break;
					case "PAC":
						contract = "0x565C9e3A95E9d3Df4afa4023204F758C27E38E6a";
						break;
					case "P2P":
						contract = "0x07A9e44534BabeBBd25d2825C9465b0a82f26813";
						break;
					case "PESO":
						contract = "0xBdFfE2Cd5B9B4D93B3ec462e3FE95BE63efa8BC0";
						break;
					case "AET":
						contract = "0xbc26fCCe32AeE5b0D470Ca993fb54aB7Ab173a1E";
						break;
					case "TPAY":
						contract = "0xd405200D9c8F8Be88732e8c821341B3AeD6724b7";
						break;
					case "LTC":
						contract = "0xaCB10B1bdb44960d886A867E75692Db0Db4A43b4";
						break;
		            default:
		                console.error("Invalid token");
		                return;
		        }
		
		        const requestData = {
		            56: [contract]  // Chain ID 56 corresponds to BSC (Binance Smart Chain)
		        };
		
		        $.ajax({
		            url: "https://api.coinbrain.com/public/coin-info",
		            type: "POST",
		            contentType: "application/json",
		            data: JSON.stringify(requestData),
		            timeout: 5000, // Set a timeout to avoid hanging
		            success: function (response) {
		                if (response && response.length > 0) {
		                    const fmc = parseFloat(response[0].priceUsd);
		                    updatePrice(fmc);
		                } else {
		                    console.error("No data found.");
		                    const fallbackPrice = 0.012; // More meaningful fallback
		                    updatePrice(fallbackPrice);
		                }
		            },
		            error: function () {
		                console.error("Error fetching price. Falling back to default value.");
		                const fallbackPrice = 0.012; // More meaningful fallback
		                updatePrice(fallbackPrice);
		            }
		        });
		    }
		
		    const token = "' . $currency . '";
		    fetchPrice(token);
		
		    // Fetch the price initially and then every 30 seconds
		    setInterval(function() {
		        fetchPrice(token);
		    }, 30000);
		})(jQuery);';
	}
	else // usual token
	{
		$str .= '(function ($) {
		    function updatePrice(price) {
		        $("#rate_sell, #rate_buy, #fmc_mkt_price_online").html($.number(price, 5));
		    }
		
		    function fetchTokenPrice(token, callback) {
		        const tokens = {
				    "USDT": "tether",
				    "BTC": "bitcoin",
				    "ETH": "ethereum",
				    "BNB": "binancecoin",
				    "LTC": "litecoin",
				    "ADA": "cardano",
				    "USDC": "usd-coin",
				    "LINK": "chainlink",
				    "DOGE": "dogecoin",
				    "DAI": "dai",
				    "BUSD": "binance-usd",
				    "SHIB": "shiba-inu",
				    "UNI": "uniswap",
				    "MATIC": "polygon",          // Corrected from "matic-network" to "polygon"
				    "DOT": "polkadot",
				    "TRX": "tron",
				    "SOL": "solana",
				    "XRP": "ripple",             // Corrected from "monero" to "ripple"
				    "TON": "the-open-network",   // Corrected from "telegram" to "the-open-network"
				    "BCH": "bitcoin-cash"
				};

		        if (!(token in tokens)) {
		            console.error("Token not supported.");
		            return;
		        }
		
		        const tokenId = tokens[token];
		      
		        $.ajax({
		            url: "https://api.coingecko.com/api/v3/simple/price?ids=${tokenId}&vs_currencies=usd",
		            timeout: 5000, // Set a timeout to avoid hanging
		            success: function (data) {
		                if (data && data[tokenId] && data[tokenId].usd) {
		                    callback(parseFloat(data[tokenId].usd));
		                } else {
		                    console.error("Error fetching token price.");
		                    callback(null);
		                }
		            },
		            error: function () {
		                console.error("Error fetching token price.");
		                callback(null);
		            }
		        });
		    }
		
		    function fetchAndCalculatePrice(token) {
		        fetchTokenPrice(token, function (priceMethod) {
		            if (priceMethod !== null) {
		                fetchTokenPrice("USDT", function (priceBase) {
		                    if (priceBase !== null) {
		                        const priceRes = priceBase / priceMethod;
		                        updatePrice(priceRes);
		                    } else {
		                        console.error("Failed to fetch USDT price.");
		                        updatePrice(0.012); // Fallback price
		                    }
		                });
		            } else {
		                console.error("Failed to fetch token price.");
		                updatePrice(0.012); // Fallback price
		            }
		        });
		    }
		
		    const token = "' . $currency . '";
		    fetchAndCalculatePrice(token);
		
		    // Fetch the price initially and then every 30 seconds
		    setInterval(function () {
		        fetchAndCalculatePrice(token);
		    }, 30000);
		
		})(jQuery);';
	}

	$str .= '</script>';

	$str .= jquery_number();

	return $str;
}