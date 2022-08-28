create table source
(
	source_id int auto_increment primary key not null,
	source_name varchar(40) not null,
	source_url varchar(255) not null,
	source_begin varchar(50) null,
	source_end varchar(50) null,
	total_words int not null,
	parsed_dtm timestamp default current_timestamp
);

create table occurrence
(
	occurrence_id int auto_increment primary key not null,
	source_id int not null references source(source_id),
	word varchar(30) not null,
	freq int not null
);