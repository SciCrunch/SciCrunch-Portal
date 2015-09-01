#v0.59

CREATE TABLE `test_xmls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

#v0.53
alter table resource_fields add weight int after hidden;
update resource_fields set weight=1;
create table fake_registry (resource_name text,description text,url text, keyword text, nif_pmid_display text, relatedto text, parent_organization text, abbrev text, synonym text, supporting_agency text, grants text, resource_type text, listedby text, lists text, usedby text, uses text, recommendedby text, recommends text, availability text, termsofuseurl text, alturl text, oldurl text, xref text, relation text, related_application text, related_disease text, located_in text, processing text, species text, supercategory text, publicationlink text, resource_pubmedids_display text, comment text, editorial_note text, resource_updated text, valid_status text, website_status text, curationstatus text, resource_type_ids text, see_full_record text, relatedtoforfacet text, date_created text, date_updated text);

insert into resources (uid,cid,version, original_id, type, typeID, status, insert_time, edit_time, curate_time) select 0,IF(listedby='Consortia-pedia',55,IF(relatedtoforfacet like '%dknet%',34,0)),1,see_full_record, IF(listedby='Consortia-pedia','Consortium',IF(supercategory='University','Institution',IF(resource_type='institute','Institution','Resource'))),IF(listedby='Consortia-pedia',17,IF(supercategory='University',18,IF(resource_type='institute',18,1))),'Curated',date_created, date_updated,date_updated from fake_registry;

insert into resource_versions (uid,cid,rid,version,status,time) select uid,cid,id,1,status,insert_time from resources
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Resource Name',b.resource_name,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Description',b.description,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Resource URL',b.url,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Keywords',b.keyword,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Defining Citation',b.nif_pmid_display,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Related To',b.relatedto,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Parent Organization',b.parent_organization,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Abbreviation',b.abbrev,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Synonyms',b.synonym,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Supporting Agency',concat(b.supporting_agency,', ',b.grants),b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,link,time) select a.id,1,'Additional Resource Types',b.resource_type,b.resource_type_ids,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Listed By',b.listedby,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Lists',b.lists,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Used By',b.usedby,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Uses',b.uses,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Recommended By',b.recommendedby,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Recommends',b.recommends,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Availability',b.availability,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Terms Of Use URL',b.termsofuseurl,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Alternate URLs',b.alturl,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Old URLs',b.oldurl,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Alternate IDs',b.xref,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Relation',b.relation,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Related Application',b.related_application,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Related Disease',b.related_disease,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Located In',b.located_in,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Processing',b.processing,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Species',b.species,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Supercategory',b.supercategory,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Publication Link',b.publicationlink,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Resource PubMed IDs',b.resource_pubmedids_display,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Comment',b.comment,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Editorial Note',b.editorial_note,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Resource Last Update',b.resource_updated,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Resource Status',b.valid_status,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Website Status',b.website_status,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Curation Status',b.curationstatus,b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Geo Location','',b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'Social URLs','',b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;
insert into resource_columns (rid,version,name,value,time) select a.id,1,'License','',b.date_updated from resources as a join fake_registry as b on a.original_id=b.see_full_record;

alter table resource_columns engine=MYISAM
create fulltext index column_search on resource_columns(value);

#v0.51
create table error_notifications (id int primary key auto_increment, uid int, type text, message text, seen int, time int);
alter table saved_searches add display text after query;