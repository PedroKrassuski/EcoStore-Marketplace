drop database if exists EcoStore;
create database EcoStore;
use EcoStore;

create table Usuario(
	CodUsu int NOT NULL AUTO_INCREMENT,
    LoginS varchar(25),
    Nome varchar(25),
    Email VARCHAR(64),
    DataNasc date,
    Senha varchar(100),
    CPF VARCHAR(25),
    TipoUsuario varchar(10),
    primary key (CodUsu)
)
ENGINE = InnoDB;

create table Telefone(
#	CodTel int NOT NULL AUTO_INCREMENT,
    CodUsu int NOT NULL,
    Numtel varchar(20)
)
ENGINE = InnoDB;


create table EnderecoVendedor(
#	CodEnd int NOT NULL AUTO_INCREMENT,
    CodVendedor int NOT NULL,
    Rua varchar(50),
    CEP int,
    Numero int,
    Bairro varchar(25),
    Complemento varchar(25)
)
ENGINE = InnoDB;

create table EnderecoComprador(
#	CodEnd int NOT NULL AUTO_INCREMENT,
    CodUsu int NOT NULL,
    Rua varchar(50),
    CEP int,
    Numero int,
    Bairro varchar(25),
    Complemento varchar(25)
)
ENGINE = InnoDB;

create table Vendedor(
	CodVendedor int NOT NULL AUTO_INCREMENT,
    CodUsu int NOT NULL,
    NomeEmp varchar(50),
    Descricao varchar(255),
    Cnpj VARCHAR(25),
    primary key (CodVendedor)
)
ENGINE = InnoDB;


create table Produto(
	CodProduto int NOT NULL AUTO_INCREMENT,
    CodVendedor int NOT NULL,
    NomeProduto VARCHAR(64),
    Validade date,
    Descricao varchar(255),
    ValorUni double,
    Foto mediumblob,
    Estoque int,
    primary key (CodProduto)
)
ENGINE = InnoDB;


create table Venda(
	CodVenda int NOT NULL AUTO_INCREMENT,
    CodUsu int NOT NULL,
#    CodProduto int,
#    CodCarrinho int NOT NULL,
    FormPag varchar(25),
    Valor double,
    DataPagamento datetime,
    primary key (CodVenda)
)
ENGINE = InnoDB;

create table Carrinho(
    CodUsu int NOT NULL,
    CodProduto int NOT NULL,
    Quantidade int,
    CodVenda int,
    Finalizado boolean
)
ENGINE = InnoDB;

#alter table Usuario
#add foreign key (Endereco) references Endereco(CodEnd),
#add foreign key (Telefone) references Telefone(CodTel);


alter table Telefone
add foreign key (CodUsu) references Usuario(CodUsu);

alter table EnderecoVendedor
add foreign key (CodVendedor) references Vendedor(CodVendedor);

alter table EnderecoComprador
add foreign key (CodUsu) references Usuario(CodUsu);

alter table Vendedor
add foreign key (CodUsu) references Usuario(CodUsu);

alter table Produto
add foreign key (CodVendedor) references Vendedor(CodVendedor);

alter table Venda
add foreign key (CodUsu) references Usuario(CodUsu);
#add foreign key (CodCarrinho) references Carrinho(CodCarrinho);
#add foreign key (CodProduto) references Produto(CodProduto);

alter table Carrinho
add foreign key (CodUsu) references Usuario(CodUsu),
add foreign key (CodProduto) references Produto(CodProduto),
add foreign key (CodVenda) references Venda(CodVenda);
