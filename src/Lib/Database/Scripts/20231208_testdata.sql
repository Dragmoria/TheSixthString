insert into category (name, description, parentId, active, media)
VALUES ('Gitaar', 'Een veelzijdig snaarinstrument dat wereldwijd wordt gebruikt in verschillende muziekstijlen. Of je nu houdt van akoestisch fingerpicking of krachtige akkoorden, de gitaar is een onmisbaar instrument voor elke muziekliefhebber.', null, 1, '{"thumbnail":{"title": "Gitaar","url": "https://images.unsplash.com/photo-1510915361894-db8b60106cb1"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1510915361894-db8b60106cb1"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Akoestische gitaar', 'Een krachtig instrument met elektrische versterking, perfect voor diverse muziekgenres zoals rock, blues en metal. Met zijn unieke klank en mogelijkheden is de elektrische gitaar een favoriet onder veel gitaristen.', 1, 1, '{"thumbnail":{"title": "Electrische Gitaar","url": "https://images.unsplash.com/photo-1510915361894-db8b60106cb1"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1510915361894-db8b60106cb1"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Elektrische gitaar', 'Een krachtig instrument met elektrische versterking, perfect voor diverse muziekgenres zoals rock, blues en metal. Met zijn unieke klank en mogelijkheden is de elektrische gitaar een favoriet onder veel gitaristen.', 1, 1, '{"thumbnail":{"title": "Basgitaar","url": "https://images.unsplash.com/photo-1564186763535-ebb21ef5277f"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1564186763535-ebb21ef5277f"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Basgitaar', 'Een essentieel element in veel muziekgenres, de basgitaar biedt een diepe, ritmische basis voor de muziek. Of je nu de voorkeur geeft aan subtiele baslijnen of krachtige slaps, de basgitaar voegt een unieke dimensie toe aan elke compositie.', 1, 1, '{"thumbnail":{"title": "Basgitaar","url": "https://images.unsplash.com/photo-1619558041249-0523903712e1"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1619558041249-0523903712e1"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Versterkers', 'Een onmisbaar onderdeel voor elke muzikant, de versterker brengt je geluid tot leven en voegt karakter toe aan je muziek. Of je nu een gitarist bent die op zoek is naar een krachtige buizenversterker of een bassist die diepe bass-tonen wil versterken, de juiste versterker maakt het verschil.', null, 1, '{"thumbnail":{"title": "Versterkers","url": "https://images.unsplash.com/photo-1535712534465-8ac1112ed593"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1535712534465-8ac1112ed593"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Plectrums', 'Een klein maar essentieel accessoire voor gitaristen, plectrums (of picks) zijn er in verschillende diktes en materialen om je de gewenste toon en speelbaarheid te geven. Of je nu strakke akkoorden speelt of snelle solos, het juiste plectrum maakt het verschil in je spel.', null, 1, '{"thumbnail":{"title": "Plectrums","url": "https://images.unsplash.com/photo-1542355365-6df0e84f06ac"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1542355365-6df0e84f06ac"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Kabels', 'Onzichtbaar maar cruciaal, kabels vormen de verbinding tussen je instrumenten, versterkers en andere audioapparatuur. Kwaliteitskabels zorgen voor een helder signaal en voorkomen ongewenste ruis, waardoor je geluid optimaal wordt overgebracht.', null, 1, '{"thumbnail":{"title": "Kabels","url": "https://images.unsplash.com/photo-1602331133462-d002177a9cec"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1602331133462-d002177a9cec"},"video":null,"secondaryImages":[]}');

##


INSERT INTO brand(name, description, active)
VALUES ('Yamaha', 'Yamaha is een toonaangevende producent van diverse muziekinstrumenten, audioapparatuur en andere innovatieve technologieën. Hun rijke geschiedenis en voortdurende streven naar kwaliteit maken Yamaha een gewaardeerd merk in de wereld van muziek en technologie.', 1);

INSERT INTO brand(name, description, active)
VALUES ('Fender', 'Een toonaangevende fabrikant van gitaren, bassen en versterkers.', 1);

INSERT INTO brand(name, description, active)
VALUES ('Gibson', 'Bekend om iconische gitaren en innovatie in de muziekindustrie.', 1);

INSERT INTO brand(name, description, active)
VALUES ('Roland', 'Producent van elektronische muziekinstrumenten en apparatuur.', 1);

INSERT INTO brand(name, description, active)
VALUES ('Martin', 'Gespecialiseerd in akoestische gitaren met een rijke geschiedenis.', 1);

INSERT INTO brand(name, description, active)
VALUES ('Korg', 'Innovatieve elektronische muziekinstrumenten en opnameapparatuur.', 1);


##
-- Electrische gitaren

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Yamaha Revstar Standard RSS02T Swift Blue elektrische gitaar met deluxe gigbag', 'Revolutionize Your Sound: Yamaha Revstar Standard RSS02T Swift Blue Electric Guitar', 'Ontdek de grenzeloze mogelijkheden van de Yamaha Revstar Standard RSS02T Swift Blue elektrische gitaar. Met zijn opvallende Swift Blue afwerking en premium ontwerp is deze gitaar een ware blikvanger op het podium. De veelzijdige klank, dankzij de hoogwaardige materialen en constructie, maakt het mogelijk om moeiteloos verschillende muziekstijlen te verkennen.

De gitaar wordt geleverd met een deluxe gigbag, waardoor je investering veilig en draagbaar blijft. Of je nu een doorgewinterde professional bent of net begint met spelen, de Yamaha Revstar Standard RSS02T biedt een uitzonderlijke speelervaring en stelt je in staat je muzikale expressie naar nieuwe hoogten te brengen.', 1, 100, 0, 795, 945, 'YP000001', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/901426/3439163/b102c8fd/450x450/1646649773RSS02T_swiftblue_front.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/901426/3439163/b102c8fd/450x450/1646649773RSS02T_swiftblue_front.jpg"},"video":{"title":"Test video","url":"https://youtu.be/6gzeT8mxK2c?list=TLGG-Fh2aJGMn1EwNzAxMjAyNA"},"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/901426/3439164/2c9d179e/450x450/1646649774RSS02T_swiftblue_angle.jpg"},{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/901426/3439165/6f09defd/450x450/1646649774RSS02T_swiftblue_back.jpg"},{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/901426/3439166/ab99e620/450x450/1646649774RS_feature_32_RSS_Gigbag.jpg"}]}', 3);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Yamaha Pacifica 012 II White elektrische gitaar', 'Unleash Your Musical Journey: Yamaha Pacifica 012 II White Electric Guitar', 'Dompel jezelf onder in de wereld van muzikale mogelijkheden met de Yamaha Pacifica 012 II White elektrische gitaar. Met zijn strakke witte afwerking en betrouwbare constructie is deze gitaar perfect voor zowel beginners als ervaren spelers. De veelzijdige klank en comfortabele speelbaarheid maken het een ideale metgezel voor elke muziekstijl.

De Yamaha Pacifica 012 II wordt geleverd met een solide ontwerp en hoogwaardige componenten, waardoor het een betrouwbare keuze is voor elke gitarist. Of je nu aan het experimenteren bent met akkoorden of je eerste solos speelt, deze gitaar biedt een geweldige start voor je muzikale reis. Upgrade je speelervaring met de Yamaha Pacifica 012 II White en laat je creativiteit de vrije loop.', 1, 100, 0, 303, 261, 'YP000001', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/800171/2982811/f926dbe0/450x450/1626194285Yamaha-PACIFICA012_1.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/800171/2982811/f926dbe0/450x450/1626194285Yamaha-PACIFICA012_1.jpg"},"video":null,"secondaryImages":[]}', 3);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (3, 'Gibson Original Collection Les Paul Standard 50s Heritage Cherry Sunburst elektrische gitaar met koffer', 'Timeless Elegance: Gibson Original Collection Les Paul Standard 50s Heritage Cherry Sunburst Electric Guitar', 'Ervaar de tijdloze elegantie van de Gibson Original Collection Les Paul Standard 50s Heritage Cherry Sunburst elektrische gitaar met koffer. Deze prachtige gitaar belichaamt de erfenis van de Les Paul-serie en biedt een harmonie tussen klassiek ontwerp en hedendaagse prestaties.

Met een verleidelijke Heritage Cherry Sunburst-afwerking en de kenmerkende Les Paul klank, brengt deze gitaar de gloriedagen van de jaren 50 terug naar het heden. De meegeleverde koffer beschermt niet alleen deze artistieke creatie, maar voegt ook een vleugje klasse toe aan je reis.

Of je nu op zoek bent naar die vintage rockklanken of de diepe tonen van de blues, de Gibson Les Paul Standard 50s Heritage Cherry Sunburst biedt een ongeëvenaarde speelervaring en blijft een icoon in de wereld van elektrische gitaren.', 1, 100, 0, 3024, 2599, 'YP000001', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/722752/2542015/385a6dbc/450x450/1607346965Gibson_Original_Collection_Les_Paul_Standard_50s_Heritage_Cherry_Sunburst_front.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/722752/2542015/385a6dbc/450x450/1607346965Gibson_Original_Collection_Les_Paul_Standard_50s_Heritage_Cherry_Sunburst_front.jpg"},"video":{"title":"Test video","url":"https://youtu.be/Obr0XGBRRZY?list=TLGGqGmCGqpJLI8wNzAxMjAyNA"},"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/722752/2542016/935f7769/450x450/1607346966Gibson_Original_Collection_Les_Paul_Standard_50s_Heritage_Cherry_Sunburst_back.jpg","url":"https://static.bax-shop.nl/image/product/722752/2542017/f836e9b1/450x450/1607346966Gibson_Original_Collection_Les_Paul_Standard_50s_Heritage_Cherry_Sunburst_side.jpg"},{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/722752/2542018/f8c8a915/450x450/1607346966Gibson_Original_Collection_Les_Paul_Standard_50s_Heritage_Cherry_Sunburst_beauty.jpg"}]}', 3);

-- Acoustische gitaren

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (2, 'Fender ESC-105 Educational Series Vintage Tint 4/4 klassieke gitaar met gigbag', 'Harmonie in Erfgoed: Fender ESC-105 Educational Series Vintage Tint 4/4 Klassieke Gitaar met Gigbag', 'Dompel jezelf onder in de rijke erfenis van klassieke muziek met de Fender ESC-105 Educational Series Vintage Tint 4/4 klassieke gitaar. Dit zorgvuldig vervaardigde instrument, verfraaid met een vintage tint, brengt niet alleen hulde aan traditie maar biedt ook een fantastisch platform voor beginners en aspirant-muzikanten.

Het 4/4 formaat zorgt voor een comfortabele speelervaring voor iedereen, terwijl de vintage tint een vleugje nostalgie toevoegt aan je muzikale reis. De meegeleverde gigbag biedt handige draagbaarheid en bescherming, waardoor het een uitstekende keuze is voor degenen die hun muzikale verkenning beginnen.

Of je nu in klassieke composities duikt of je eigen muzikale creaties omarmt, belooft de Fender ESC-105 een harmonieuze mix van erfgoed en modern vakmanschap om je te begeleiden op je muzikale avonturen.', 1, 100, 0, 137, 121, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/576783/1970253/30c40599/450x450/1574156395Fender_ESC_105_vintage_tint_front.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/576783/1970253/30c40599/450x450/1574156395Fender_ESC_105_vintage_tint_front.jpg"},"video":null,"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/576783/1970254/c5264c2f/450x450/1574156395Fender_ESC_105_vintage_tint_back.jpg"}]}', 2);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Yamaha C40II klassieke gitaar 4/4 naturel', 'Eenvoud in Natuurlijkheid: Yamaha C40II Klassieke Gitaar 4/4 Naturel', 'Ervaar de tijdloze eenvoud van de Yamaha C40II klassieke gitaar in een natuurlijke afwerking. Met een volledig formaat (4/4) en een naturel uiterlijk biedt deze gitaar een ideale balans tussen traditioneel vakmanschap en moderne speelbaarheid.

De C40II is ontworpen om zowel beginners als gevorderde spelers een comfortabele en inspirerende speelervaring te bieden. De natuurlijke afwerking benadrukt de schoonheid van het hout en voegt een vleugje warmte toe aan de klank. Of je nu net begint met spelen of je muzikale reis voortzet, de Yamaha C40II belooft betrouwbaarheid en tijdloze klasse voor elke gitarist.', 1, 100, 0, 191, 111, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/30267/3466199/c56e4e26/450x450/164784656020220317-Yam%2Caha%20C40II%20Classic_4.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/30267/3466199/c56e4e26/450x450/164784656020220317-Yam%2Caha%20C40II%20Classic_4.jpg"},"video":null,"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/30267/3477933/2f8df209/450x450/164845026420220323-_MG_3305.jpg"}]}', 2);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Yamaha SLG200NW Silent Guitar Natural elektrisch-akoestische klassieke gitaar met gigbag', 'Stil Genieten van Natuurlijk Geluid: Yamaha SLG200NW Silent Guitar Natural Elektrisch-Akoestische Klassieke Gitaar met Gigbag', 'Ervaar het beste van twee werelden met de Yamaha SLG200NW Silent Guitar. Deze elektrisch-akoestische klassieke gitaar in natuurlijke afwerking biedt een ongekende veelzijdigheid zonder afbreuk te doen aan de klassieke klank.

Of je nu wilt oefenen zonder anderen te storen, op het podium staat, of gewoon van een stille jamsessie wilt genieten, de SLG200NW levert. Met een slank ontwerp en een natuurlijke klank, biedt deze gitaar de vrijheid om te spelen waar je maar wilt.

De meegeleverde gigbag zorgt voor bescherming en draagbaarheid, waardoor de Yamaha SLG200NW de perfecte metgezel is voor muzikanten die op zoek zijn naar de ultieme mix van functionaliteit en verfijning.', 1, 100, 0, 915, 809, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/327143/1527511/26e583b9/450x450/1536576240_MG_5386.JPG"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/327143/1527511/26e583b9/450x450/1536576240_MG_5386.JPG"},"video":null,"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/327143/1527512/60912c6e/450x450/1536576243_MG_5393.JPG"}]}', 2);

-- Basgitaren

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Gibson Original Collection SG Standard Bass Ebony elektrische basgitaar met koffer', 'Diepe Klanken in Onyx Zwart: Gibson Original Collection SG Standard Bass Ebony Elektrische Basgitaar met Koffer', 'Laat de diepe klanken resoneren met de Gibson Original Collection SG Standard Bass in Ebony-afwerking. Deze elektrische basgitaar, vergezeld van een stevige koffer, belichaamt de erfenis van Gibson met zijn klassieke SG-ontwerp en krachtige prestaties.

Met een rijke Ebony-afwerking en kenmerkende SG-styling levert deze basgitaar niet alleen een visueel statement maar ook een sonische kracht. Het slanke ontwerp en de veelzijdige klank maken het een favoriet onder bassisten in verschillende muziekgenres.

Of je nu diepe grooves wilt creëren in de studio of het podium wilt veroveren, de Gibson SG Standard Bass in Ebony met koffer biedt de perfecte combinatie van stijl, comfort en prestaties voor elke bassist.', 1, 100, 0, 1930, 1655, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/724764/2550413/0ee2d4e1/450x450/1607680976Gibson_Original_Collection_SG_Standard_Bass_Ebony_front.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/724764/2550413/0ee2d4e1/450x450/1607680976Gibson_Original_Collection_SG_Standard_Bass_Ebony_front.jpg"},"video":null,"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/724764/3855252/ee301d3d/450x450/1663832336_MG_7444.jpg"},{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/724764/2550414/0dc1823a/450x450/1607680976Gibson_Original_Collection_SG_Standard_Bass_Ebony_back.jpg"}]}', 3);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Fender American Vintage II 1954 Precision Bass MN Vintage Blonde elektrische basgitaar met koffer', 'Terug naar de Oorsprong: Fender American Vintage II 1954 Precision Bass MN Vintage Blonde Elektrische Basgitaar met Koffer', 'Ervaar de essentie van vintage klanken met de Fender American Vintage II 1954 Precision Bass in Vintage Blonde. Deze elektrische basgitaar, compleet met een luxe koffer, neemt je mee terug naar het iconische geluid van de jaren 50.

Met zijn Vintage Blonde afwerking en klassieke Precision Bass styling biedt deze gitaar niet alleen een eerbetoon aan het verleden, maar levert ook de authentieke tonen waar Fender om bekend staat. Het esdoornhouten fretboard voegt een warme touch toe aan de klank, terwijl de koffer zorgt voor bescherming en draagbaarheid.

Of je nu op het podium staat of in de studio, de Fender American Vintage II 1954 Precision Bass brengt de tijdloze klanken van het verleden naar het heden, en biedt bassisten een unieke en inspirerende speelervaring.', 1, 100, 0, 2599, 2155, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://static.bax-shop.nl/image/product/1013203/3882252/39c0c75a/450x450/16653853170190152807_fen_ins_frt_1_rr.jpg"},"mainImage":{"title":"Test main image","url":"https://static.bax-shop.nl/image/product/1013203/3882252/39c0c75a/450x450/16653853170190152807_fen_ins_frt_1_rr.jpg"},"video":null,"secondaryImages":[{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/1013203/3884729/a73b3a58/450x450/166547503454%2002.jpg"},{"title":"Test thumbnail","url":"https://static.bax-shop.nl/image/product/1013203/3882253/a240af4b/450x450/16653853170190152807_fen_ins_bck_1_rl.jpg"}]}', 3);

##

insert into user (emailAddress, passwordHash, role, firstName, lastName, gender, active, createdOn)
VALUES ('admin@thesixthstring.store', '$2y$10$UXVWpnsLzqbOuSbZ2XEk.uff33oLtLLZVKGtYfH1cMEGbB/yxEIay', 0, 'Admin', 'De Admin', 0, 1, '2023-12-08');

##

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 1, '1234AA', 'Amsterdam', 0, 1, 0);

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 2, '1234AB', 'Amsterdam', 0, 1, 1);

##

insert into `order` (userId, orderTotal, orderTax, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn)
VALUES (1, 100, 21, 1, 2, 0, 0, '2023-12-08');

##

insert into orderitem (orderId, productId, unitPrice, quantity, status)
VALUES (1, 1, 100, 1, 0);

##

insert into review (rating, title, content, orderItemId, status, createdOn)
VALUES (4, 'Testreview', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultricies euismod nunc, vel tincidunt erat viverra eu. Mauris aliquet lectus sed justo vestibulum tincidunt. Phasellus auctor posuere ligula a vehicula. Integer ultrices tempus quam ut dictum. In dignissim orci et blandit efficitur. Curabitur fermentum sapien augue, ac sodales nunc venenatis in. Fusce nec lorem et ipsum aliquet mollis id at mi. Integer vel porta leo, sit amet accumsan tellus. Quisque facilisis ligula nisi, vitae fermentum dolor sagittis et. Mauris eu imperdiet orci. Nunc turpis orci, efficitur vel venenatis vitae, feugiat eu odio. Pellentesque at consequat dolor. Morbi et convallis dui. Phasellus euismod justo eu enim scelerisque tristique. In sit amet tristique eros.', 1, 1, '2023-12-08');

##

insert into coupon (name, code, value, startDate, active, usageAmount, type) values ('test', 'test123', 50, '2023-12-30', 1, 0, 0);

##

insert into paymentprovider (name, apiKey, apiSecret, active) values ('mollie_test', 'pfl_n9bVYJvoSS', 'test_H5R3c6ek3QypnQsNw3kCGmPgGr8WPT', 1)