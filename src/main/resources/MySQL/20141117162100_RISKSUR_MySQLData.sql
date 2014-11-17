
/*Data for the table `frameworkHeader` */
insert  into `frameworkHeader`(`frameworkId`,`name`,`userId`,`goalId`,`description`) values (1,'Cattle Surveillance',7,1,'Cattle Surveillance'),(2,'Sheep Surveillance',7,2,'Sheep Surveillance'),(3,'chicken Surveilence',7,1,'chicken Surveilence');


/*Data for the table `componentHead` */

insert  into `componentHead`(`componentId`,`frameworkId`,`componentName`,`comments`) values (1,3,'Contamination test',NULL),(2,3,'Feathers Check',NULL),(3,1,'Fodder test',NULL),(4,1,'Health Check',NULL);

/*Data for the table `componentDetails` */

insert  into `componentDetails`(`componentDetailId`,`componentId`,`subFormId`,`value`,`comments`) values (1,1,1,'Pasive',NULL),(2,1,2,'2',NULL),(3,1,3,'4',NULL),(4,1,4,'7',NULL),(5,1,5,'50',NULL),(6,1,7,'Bird flu',NULL),(7,2,1,'Pasive',NULL),(8,2,2,'2',NULL),(9,2,3,'4',NULL),(10,2,4,'7',NULL),(11,2,5,'50',NULL),(12,2,7,'soggy feathers',NULL),(13,3,1,'Active',NULL),(14,3,2,'1',NULL),(15,3,3,'4',NULL),(16,3,4,'7',NULL),(17,3,5,'10',NULL),(18,3,7,'Foot and Mouth',NULL),(19,4,1,'Active',NULL),(20,4,2,'1',NULL),(21,4,3,'5',NULL),(22,4,4,'7',NULL),(23,4,5,'20',NULL),(24,4,7,'real',NULL);
