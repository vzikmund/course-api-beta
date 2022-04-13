-- Start transaction to ensure everything or nothing is inserted
START TRANSACTION;


-- INSERT DATA INTO THE VENDOR DICTIONARY TABLE
INSERT INTO vendor (id, name, redeem_information) VALUES (1, 'Netlfix', 'Začněte se dívat:\n\nJděte na www.netflix.com/kod\nZadejte kód\n\nPlatí pouze pro službu Netflix a přes účet Netflix (od 18 let). Po uplatnění se celá částka převede na účet Netflix. Kromě případů stanovených zákonem nelze vracet ani jinak proplácet v hotovosti. Časově neomezená platnost. Zákaz dalšího prodeje. Netflix neodpovídá za ztracené nebo ukradené karty ani jejich případné neautorizované využití. Kompletní podmínky naleznete na www.netflix.com/cardterms. Vydává Netflix International B.V.');
INSERT INTO vendor (id, name, redeem_information) VALUES (2, 'Sony', 'Redeem the code after logging in to your PlayStation account either on the console or in the browser at store.playstation.com under <b> Redeem Codes </b>.\nPlayStation customer support can be contacted at https://www.playstation.com/cs-cz/get-help/.');
INSERT INTO vendor (id, name, redeem_information) VALUES (3, 'Xbox', 'Redeem the code on the console at the Store page under <b>Use Code</b> or in your browser at www.xbox.com under <b>Redeem Code</b>.\n\nMicrosoft Customer Support can be contacted at +420 261 197 665 or 841 300 300. Support can be contacted on weekdays from 9:00 to 17:30.\n\nIt is also possible to use non-stop chat support at https://support.xbox.com. All you have to do is select your problem from the interactive list and then click on the "Contact us" button.');
INSERT INTO vendor (id, name, redeem_information) VALUES (4, 'Steam', 'If you already have a Steam client, you can activate the product by going to the <b>Library</b> tab in that client and clicking on the <b>+</b> icon at the bottom.\n\nOtherwise, head to www.steampowered.com/wallet. Enter the unique code for your wallet, shown below, and follow the instructions. Funds will be added to your account and you will be redirected to the game page where you will complete your purchase. Have fun!\n\nIf you need help, visit www.steampowered.com/wallet/support\n\nThe sale is made in the name and on behalf of Valve Corporation.');


-- INSERT DATA INTO THE PRODUCT TABLE
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (26420, 1, 'Netflix Gift Card 50 EUR', 50.00, 978);
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (37930, 4, 'Steam Wallet Gift Card 10 EUR', 10.00, 978);
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (59161, 4, 'Steam Wallet Gift Card 25 EUR', 25.00, 978);
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (68508, 1, 'Netflix Gift Card 15 EUR', 15.00, 978);
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (77265, 2, 'Playstaion Wallet Gift Card 100 EUR', 100.00, 978);
INSERT INTO product (id, vendor_id, name, recommended_price, currency_code) VALUES (81320, 2, 'Playstaion Wallet Gift Card 10 EUR', 10.00, 978);

-- INSERT DATA INTO THE RETAILER TABLE
-- - PASSWORD FOR CREATING api_key is kT4s>nE[V<x2cvT!
-- - - Decrypted password for the retailer: api_key_gas_station
INSERT INTO retailer (id, name, email, api_key, is_active) VALUES (5875, 'Gas Station', 'gas@station.com', 0xDEF502003F1564FFED149683FA5CC3CA501C4E99910661FF23CF25531875BC2CF0361F39377749B258F2871A433258331A2CA4E872DDDB09623C22D688F314FB4DCBB98D1DB944814DE910D237B2DAEFBC4A5091ECB955B081F442FA4ADCC65C9ABD265C670E21, 1);

-- - - Decrypted password for retailer api_key_supermarket
INSERT INTO retailer (id, name, email, api_key, is_active) VALUES (6631, 'Supermarket', 'super@market.com', 0xDEF50200284ACD2AD5A647DF2008401F1718E8CE268382D1BB7611C380586D85ECD0B82EEE93BEBA8F4C424F654E1C77BA2551B1654CE744281E685025BA5C6EEB387F769A5CFD22331EC4577EE3DE107B010619AEE93BB3112F449606D8314643DE2A6C35356C, 1);

-- - - Decrypted password for retailer api_key_convenience_store
INSERT INTO retailer (id, name, email, api_key, is_active) VALUES (7458, 'Convenience Store', 'convenience@store.com', 0xDEF5020048A42DDF86DF069AE0FDB9E643F7CD92498EE6F0E6B265FE1A0F0ABBA6128BDA6AE8488369EAAC976BC111DF0171F2BFDB17529713222944AC2A7427E114D93A02D38676E3C997778D7801E7D501C760439D997A82F23FF67F0417677D13A679DE72F2148AB9162CFC, 0);

-- CREATE ASSOCIATION BETWEEN A RETAILER AND A PRODUCT
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (26420, 7458, 48.75, 978, 1);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (37930, 6631, 9.50, 978, 1);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (59161, 6631, 23.75, 978, 1);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (68508, 6631, 14.25, 978, 0);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (68508, 7458, 14.63, 978, 0);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (77265, 5875, 98.00, 978, 1);
INSERT INTO retailer_product (product_id, retailer_id, cost, currency_code, is_active) VALUES (81320, 5875, 9.80, 978, 1);

-- insert all data or none
COMMIT;