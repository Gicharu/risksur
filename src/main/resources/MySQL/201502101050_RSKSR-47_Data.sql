INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(43,'Evaluation Page','Evaluation Page','evaluation','evaPage',''),
(44,'Save Evaluation Page','Save Evaluation Page','evaluation','saveEvaPage',''),
(45,'upload image Page','upload image Page','evaluation','imageUpload',''),
(46,'Eva Concepts','Eva Concepts','evaluation','evaConcept',''),
(47,'Save Evaluation Concept','Save Evaluation Concept','evaluation','saveEvaConcept','')
;

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(43,1),(43,2),(43,3),
(44,1),(44,2),
(45,1),(45,2),
(46,1),(46,2),(46,3),
(47,1),(47,2)
;

insert  into `docPages`(`docId`,`docName`,`docData`) values (1,'evaPage','%3Cp%3E%0A%09%3Cstrong%3ELo%3Cspan%20style%3D%22color%3A%20rgb(36%2C%2064%2C%2097)%3B%22%20data-redactor-tag%3D%22span%22%3Erem%20Ipsum%20is%20simply%20dumext%3C%2Fspan%3E%20of%20the%20printing%20%3C%2Fstrong%3E%0A%3C%2Fp%3E%0A%3Cp%3E%0A%09%3Cimg%20style%3D%22%22%20rel%3D%22%22%20src%3D%22%2Frisksur%2Fimages%2FcustomImageUpload%2F2089d06b17e2de380bf07bc6dc5f4d79.jpg%22%3E%0A%3C%2Fp%3E%0A%3Cp%3E%0A%09%3Cem%3Ean%3Cspan%20style%3D%22background-color%3A%20rgb(217%2C%20150%2C%20148)%3B%22%20data-redactor-tag%3D%22span%22%3Ed%20typesetting%20industry.%20Lorem%20Ips%3C%2Fspan%3Eum%20has%20been%20the%20industry\'s%20%3C%2Fem%3E%0A%3C%2Fp%3E%0A%3Col%3E%0A%09%3Cli%3Estandard%20dummy%20text%20ever%20since%20the%20%3Cem%3E1500s%2C%20when%20an%20unknown%20printer%20took%20a%20galley%20of%20%3C%2Fem%3E%3C%2Fli%3E%0A%3C%2Fol%3E%0A%3Cp%3E%0A%09%3Cdel%3Etype%20and%20scrambled%20it%20to%20make%20a%20type%20specimen%20book.%20It%20has%20survived%20not%20only%20five%20centuries%2C%20%3C%2Fdel%3E%0A%3C%2Fp%3E%0A%3Cp%3E%0A%09but%20also%20the%20leap%20into%20electronic%0A%3C%2Fp%3E%0A%3Ch2%3E%20typesetting%2C%20remaining%20essentially%20unchanged.%20%3C%2Fh2%3E%0A%3Cblockquote%3E%0A%09It%20was%20popularised%20in%20the%201960s%20with%0A%3C%2Fblockquote%3E%0A%3Cp%3E%0A%09the%20release%20of%20Letraset%20sheets%20containing%20Lorem%20Ipsum%20passages%2C%20and%20more%20recently%20with%20desktop%20publishing%20software%20like%20Aldus%20PageMaker%20including%20versions%20of%20Lorem%20Ipsum.%0A%3C%2Fp%3E');

insert  into `docPages`(`docId`,`docName`,`docData`) values (2,'evaConcepts','%3Ch1%3ELorem%20ipsum%3Cbr%3E%0A%3C%2Fh1%3E%0A%3Col%3E%0A%09%3Cli%3ELorem%20ipsum%20dolor%20sit%20amet%2C%20consectetur%20adipiscing%20elit.%20Mauris%20vitae%20mi%20sollicitudin%20urna%20imperdiet%20imperdiet.%20Donec%20nulla%20purus%2C%20lacinia%20ac%20bibendum%20non%2C%20rutrum%20nec%20eros.%20Aliquam%20a%20tellus%20metus.%20Quisque%20sed%20posuere%20velit.%20Curabitur%20porta%20sem%20a%20molestie%20tristique.%20Vivamus%20id%20accumsan%20dolor.%20Vestibulum%20euismod%20ante%20eu%20elementum%20molestie.%20Morbi%20aliquet%20pretium%20ipsum%20id%20fermentum.%20In%20suscipit%20tortor%20tincidunt%20diam%20lacinia%20scelerisque.%3C%2Fli%3E%0A%3C%2Fol%3E%0A%3Cp%20style%3D%22text-align%3A%20justify%3B%20font-size%3A%2011px%3B%20line-height%3A%2014px%3B%20margin%3A%200px%200px%2014px%3B%20padding%3A%200px%3B%20color%3A%20rgb(0%2C%200%2C%200)%3B%20font-family%3A%20Arial%2C%20Helvetica%2C%20sans%3B%20font-style%3A%20normal%3B%20font-variant%3A%20normal%3B%20font-weight%3A%20normal%3B%20letter-spacing%3A%20normal%3B%20orphans%3A%20auto%3B%20text-indent%3A%200px%3B%20text-transform%3A%20none%3B%20white-space%3A%20normal%3B%20widows%3A%20auto%3B%20word-spacing%3A%200px%3B%20-webkit-text-stroke-width%3A%200px%3B%22%3E%0A%09Sed%20ac%20turpis%20quam.%20Nam%20pharetra%20metus%20in%20quam%20pharetra%2C%20eu%20ultricies%20lorem%20iaculis.%20Pellentesque%20vestibulum%20arcu%20quis%20metus%20commodo%2C%20lobortis%20hendrerit%20tellus%20interdum.%20Vestibulum%20porttitor%20sagittis%20nibh%2C%20eget%20sollicitudin%20dui%20laoreet%20vel.%20In%20pretium%20diam%20ut%20erat%20varius%20lacinia.%20Mauris%20porttitor%20vel%20sem%20vitae%20ornare.%20Nullam%20tempus%20risus%20sit%20amet%20pellentesque%20egestas.%20Maecenas%20consectetur%2C%20justo%20eu%20egestas%20viverra%2C%20nulla%20lacus%20interdum%20libero%2C%20a%20ornare%20ligula%20massa%20eget%20tortor.%20Proin%20ultricies%20vestibulum%20lacus%20sit%20amet%20pharetra.%20Fusce%20eu%20nisi%20ultrices%2C%20eleifend%20velit%20in%2C%20auctor%20enim.%0A%3C%2Fp%3E%0A%3Cp%20style%3D%22text-align%3A%20justify%3B%20font-size%3A%2011px%3B%20line-height%3A%2014px%3B%20margin%3A%200px%200px%2014px%3B%20padding%3A%200px%3B%20color%3A%20rgb(0%2C%200%2C%200)%3B%20font-family%3A%20Arial%2C%20Helvetica%2C%20sans%3B%20font-style%3A%20normal%3B%20font-variant%3A%20normal%3B%20font-weight%3A%20normal%3B%20letter-spacing%3A%20normal%3B%20orphans%3A%20auto%3B%20text-indent%3A%200px%3B%20text-transform%3A%20none%3B%20white-space%3A%20normal%3B%20widows%3A%20auto%3B%20word-spacing%3A%200px%3B%20-webkit-text-stroke-width%3A%200px%3B%22%3E%0A%09%3Cem%3ESuspendisse%20justo%20mi%2C%20sollicitudin%20sed%20mi%20et%2C%20elementum%20hendrerit%20lorem.%20In%20libero%20nulla%2C%20suscipit%20nec%20placerat%20vel%2C%20volutpat%20in%20est.%20Fusce%20condimentum%20tincidunt%20risus.%20Proin%20vel%20volutpat%20enim.%20Vivamus%20eget%20ornare%20velit%2C%20ut%20porttitor%20purus.%20Sed%20fermentum%20libero%20felis%2C%20eget%20volutpat%20urna%20commodo%20quis.%20Pellentesque%20habitant%20morbi%20tristique%20senectus%20et%20netus%20et%20malesuada%20fames%20ac%20turpis%20egestas.%20Praesent%20nec%20justo%20a%20enim%20accumsan%20rutrum.%20Vestibulum%20egestas%20orci%20nec%20quam%20maximus%20tincidunt.%20Maecenas%20eu%20diam%20faucibus%20erat%20pharetra%20interdum.%3C%2Fem%3E%0A%3C%2Fp%3E%0A%3Ch5%3ECurabitur%20quis%20fermentum%20risus.%20Donec%20gravida%20ac%20eros%20quis%20bibendum.%20Proin%20eu%20tempus%20diam%2C%20at%20tristique%20ipsum.%20Suspendisse%20et%20lacus%20ullamcorper%2C%20convallis%20quam%20sit%20amet%2C%20accumsan%20neque.%20Cras%20auctor%20eros%20mauris%2C%20et%20pharetra%20erat%20aliquet%20quis.%20Nullam%20dictum%20venenatis%20metus%2C%20a%20viverra%20risus%20tempor%20vitae.%20Curabitur%20placerat%20ligula%20lobortis%20sapien%20rutrum%2C%20eu%20convallis%20massa%20lobortis.%20Integer%20faucibus%20ex%20in%20augue%20malesuada%2C%20mattis%20ullamcorper%20orci%20maximus.%20Nam%20et%20augue%20quis%20neque%20tempus%20tristique.%3C%2Fh5%3E%0A%3Cp%20style%3D%22text-align%3A%20justify%3B%20font-size%3A%2011px%3B%20line-height%3A%2014px%3B%20margin%3A%200px%200px%2014px%3B%20padding%3A%200px%3B%20color%3A%20rgb(0%2C%200%2C%200)%3B%20font-family%3A%20Arial%2C%20Helvetica%2C%20sans%3B%20font-style%3A%20normal%3B%20font-variant%3A%20normal%3B%20font-weight%3A%20normal%3B%20letter-spacing%3A%20normal%3B%20orphans%3A%20auto%3B%20text-indent%3A%200px%3B%20text-transform%3A%20none%3B%20white-space%3A%20normal%3B%20widows%3A%20auto%3B%20word-spacing%3A%200px%3B%20-webkit-text-stroke-width%3A%200px%3B%22%3E%0A%09Nullam%20nec%20orci%20nec%20est%20sollicitudin%20tincidunt%20eget%20sed%20mi.%20Aliquam%20sollicitudin%20nisi%20eu%20tellus%20tristique%2C%20sit%20amet%20dignissim%20tortor%20blandit.%20Fusce%20porta%20odio%20in%20iaculis%20tempor.%20Sed%20eu%20lacus%20et%20sem%20facilisis%20congue.%20Nulla%20finibus%20mollis%20justo%20et%20tincidunt.%20Aliquam%20ut%20vulputate%20erat.%20Curabitur%20laoreet%20elit%20dolor.%20Mauris%20dignissim%20vitae%20ligula%20quis%20maximus.%20Mauris%20consectetur%20sit%20amet%20enim%20et%20dignissim.%20Etiam%20mi%20nunc%2C%20vulputate%20at%20vulputate%20a%2C%20suscipit%20in%20justo.%20Cras%20dolor%20leo%2C%20maximus%20finibus%20diam%20non%2C%20mollis%20rhoncus%20augue.%0A%3C%2Fp%3E');
