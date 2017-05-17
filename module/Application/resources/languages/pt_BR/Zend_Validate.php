<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

/**
 * EN-Revision: 16.Jun.2015
 */
return [
    // Zend\Authentication\Validator\Authentication
    "Invalid identity" => "Credencial inválida",
    "Identity is ambiguous" => "Mais de uma credencial encontrada",
    "Invalid password" => "Senha incorreta",
    "Authentication failed" => "A autenticação falhou",

    // Zend\I18n\Validator\Alnum
    "Invalid type given. String, integer or float expected" => "O tipo especificado é inválido, o valor deve ser float, string, ou inteiro",
    "The input contains characters which are non alphabetic and no digits" => "O valor de entrada contém caracteres que não são alfabéticos e nem dígitos",
    "The input is an empty string" => "O valor de entrada é uma string vazia",

    // Zend\I18n\Validator\Alpha
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",
    "The input contains non alphabetic characters" => "O valor de entrada contém caracteres não alfabéticos",
    "The input is an empty string" => "O valor de entrada é uma string vazia",

    // Zend\I18n\Validator\DateTime
    "Invalid type given. String expected" => "A data é inválida",
    "The input does not appear to be a valid datetime" => "A data é inválida",

    // Zend\I18n\Validator\IsFloat
    "Invalid type given. String, integer or float expected" => "O tipo especificado é inválido, o valor deve ser float, string, ou inteiro",
    "The input does not appear to be a float" => "O valor de entrada não parece ser to tipo float",

    // Zend\I18n\Validator\IsInt
    "Invalid type given. String or integer expected" => "O número é inválido",
    "The input does not appear to be an integer" => "O número é inválido",

    // Zend\I18n\Validator\PhoneNumber
    "The input does not match a phone number format" => "O telefone é inválido",
    "The country provided is currently unsupported" => "O telefone é inválido",
    "Invalid type given. String expected" => "O telefone é inválido",

    // Zend\I18n\Validator\PostCode
    "Invalid type given. String or integer expected" => "O CEP inválido",
    "The input does not appear to be a postal code" => "O CEP inválido",
    "An exception has been raised while validating the input" => "O CEP inválido",

    // Zend\Validator\Barcode
    "The input failed checksum validation" => "O valor de entrada falhou na validação do checksum",
    "The input contains invalid characters" => "O valor de entrada contém caracteres inválidos",
    "The input should have a length of %length% characters" => "O valor de entrada deveria ter %length% caracteres de comprimento",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser string",

    // Zend\Validator\Between
    "The input is not between '%min%' and '%max%', inclusively" => "O valor de entrada não está entre '%min%' e %max%, inclusivamente",
    "The input is not strictly between '%min%' and '%max%'" => "O valor de entrada não está exatamente entre '%min%' e %max%",

    // Zend\Validator\Bitwise
    "The input has no common bit set with '%control%'" => "O valor de entrada não possui o bit comum definido como %control%",
    "The input doesn't have the same bits set as '%control%'" => "O valor de entrada não possui o mesmo conjunto de bits do que %control%",
    "The input has common bit set with '%control%'" => "O valor de entrada possui o mesmo conjunto de bits do que %control%",

    // Zend\Validator\Callback
    "The input is not valid" => "O valor de entrada não é válido",
    "An exception has been raised within the callback" => "Uma exceçao foi lançada na chamada de retorno",

    // Zend\Validator\CreditCard
    "The input seems to contain an invalid checksum" => "O valor de entrada parece conter um checksum inválido",
    "The input must contain only digits" => "O valor de entrada deve conter apenas dígitos",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser string",
    "The input contains an invalid amount of digits" => "O valor de entrada contém uma quantidade inválida de dígitos",
    "The input is not from an allowed institute" => "O valor de entrada não vem de uma instituição autorizada",
    "The input seems to be an invalid credit card number" => "O valor de entrada parece ser um número de cartão de crédito inválido",
    "An exception has been raised while validating the input" => "Uma exceçao foi lançada durante a validação do valor de entrada",

    // Zend\Validator\Csrf
    "The form submitted did not originate from the expected site" => "Ocorreu um erro. Tente novamente.",

    // Zend\Validator\Date
    "Invalid type given. String, integer, array or DateTime expected" => "A data é inválida",
    "The input does not appear to be a valid date" => "A data é inválida",
    "The input does not fit the date format '%format%'" => "A data é inválida",

    // Zend\Validator\DateStep
    "Invalid type given. String, integer, array or DateTime expected" => "O valor informado é inválido (1)",
    "The input does not appear to be a valid date" => "O valor informado é inválido (2)",
    "The input is not a valid step" => "O valor informado é inválido (3)",

    // Zend\Validator\Db_AbstractDb
    "No record matching the input was found" => "O valor informado não existe",
    "A record matching the input was found" => "O valor informado já está cadastrado",

    // Zend\Validator\Digits
    "The input must contain only digits" => "O valor informado é inválido",
    "The input is an empty string" => "O valor informado é inválido",
    "Invalid type given. String, integer or float expected" => "O valor informado é inválido",

    // Zend\Validator\EmailAddress
    "Invalid type given. String expected" => "O e-mail é inválido",
    "The input is not a valid email address. Use the basic format local-part@hostname" => "O e-mail é inválido",
    "'%hostname%' is not a valid hostname for the email address" => "O e-mail é inválido",
    "'%hostname%' does not appear to have any valid MX or A records for the email address" => "O e-mail é inválido",
    "'%hostname%' is not in a routable network segment. The email address should not be resolved from public network" => "O e-mail é inválido",
    "'%localPart%' can not be matched against dot-atom format" => "O e-mail é inválido",
    "'%localPart%' can not be matched against quoted-string format" => "O e-mail é inválido",
    "'%localPart%' is not a valid local part for the email address" => "O e-mail é inválido",
    "The input exceeds the allowed length" => "O e-mail é inválido",

    // Zend\Validator\Explode
    "Invalid type given" => "Tipo inválido",

    // Zend\Validator\File\Count
    "Too many files, maximum '%max%' are allowed but '%count%' are given" => "Há muitos arquivos, são permitidos no máximo '%max%', mas %count% foram fornecidos",
    "Too few files, minimum '%min%' are expected but '%count%' are given" => "Há poucos arquivos, são esperados no mínimo '%min%', mas %count% foram fornecidos",

    // Zend\Validator\File\Crc32
    "File does not match the given crc32 hashes" => "O arquivo não corresponde a hash crc32 fornecida",
    "A crc32 hash could not be evaluated for the given file" => "Não foi possível avaliar uma hash crc32 para o arquivo fornecido",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\ExcludeExtension
    "File has an incorrect extension" => "O arquivo possui uma extensão incorreta",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\Exists
    "File does not exist" => "O arquivo %value% não existe",

    // Zend\Validator\File\Extension
    "File has an incorrect extension" => "O arquivo possui uma extensão incorreta",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\FilesSize
    "All files in sum should have a maximum size of '%max%' but '%size%' were detected" => "Os arquivos devem ter no máximo %max%",
    "All files in sum should have a minimum size of '%min%' but '%size%' were detected" => "Os arquivos devem ter no mínimo %min%",
    "One or more files can not be read" => "Um ou mais arquivos não podem ser lidos",

    // Zend\Validator\File\Hash
    "File does not match the given hashes" => "O arquivo não corresponde as hashes fornecidas",
    "A hash could not be evaluated for the given file" => "Não foi possível avaliar uma hash para o arquivo fornecido",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\ImageSize
    "Maximum allowed width for image should be '%maxwidth%' but '%width%' detected" => "A largura máxima deve ser %maxwidth%px",
    "Minimum expected width for image should be '%minwidth%' but '%width%' detected" => "A largura mínima deve ser %minwidth%px",
    "Maximum allowed height for image should be '%maxheight%' but '%height%' detected" => "A altura máxima deve ser %maxheight%px",
    "Minimum expected height for image should be '%minheight%' but '%height%' detected" => "A altura mínima deve ser %minheight%px",
    "The size of image could not be detected" => "O tamanho da imagem não pôde ser detectado",
    "File is not readable or does not exist" => "O arquivo é inválido",

    // Zend\Validator\File\IsCompressed
    "File is not compressed, '%type%' detected" => "O arquivo não está compactado: %type% detectado",
    "The mimetype could not be detected from the file" => "O mimetype do arquivo não pôde ser detectado",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\IsImage
    "File is no image, '%type%' detected" => "O arquivo deve ser uma imagem",
    "The mimetype could not be detected from the file" => "O formato do arquivo é inválido",
    "File is not readable or does not exist" => "O arquivo é inválido",

    // Zend\Validator\File\Md5
    "File does not match the given md5 hashes" => "O arquivo não corresponde as hashes md5 fornecidas",
    "An md5 hash could not be evaluated for the given file" => "Não foi possível avaliar uma hash md5 para o arquivo fornecido",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\MimeType
    "File has an incorrect mimetype of '%type%'" => "O formato do arquivo está incorreto: %type%",
    "The mimetype could not be detected from the file" => "O formato do arquivo não pôde ser detectado",
    "File is not readable or does not exist" => "O arquivo é inválido",

    // Zend\Validator\File\NotExists
    "File exists" => "O arquivo já existe",

    // Zend\Validator\File\Sha1
    "File does not match the given sha1 hashes" => "O arquivo não corresponde as hashes sha1 fornecidas",
    "A sha1 hash could not be evaluated for the given file" => "Não foi possível avaliar uma hash sha1 para o arquivo fornecido",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\File\Size
    "Maximum allowed size for file is '%max%' but '%size%' detected" => "O tamanho máximo deve ser %max%",
    "Minimum expected size for file is '%min%' but '%size%' detected" => "O tamanho mínimo deve ser %min%",
    "File is not readable or does not exist" => "O arquivo é inválido",

    // Zend\Validator\File\Upload
    "File '%value%' exceeds the defined ini size" => "O arquivo %value% excede o tamanho definido na configuração",
    "File '%value%' exceeds the defined form size" => "O arquivo %value% excede o tamanho definido do formulário",
    "File '%value%' was only partially uploaded" => "O arquivo %value% foi apenas parcialmente enviado",
    "File '%value%' was not uploaded" => "O arquivo %value% não foi enviado",
    "No temporary directory was found for file '%value%'" => "Nenhum diretório temporário foi encontrado para o arquivo %value%",
    "File '%value%' can't be written" => "O arquivo %value% não pôde ser escrito",
    "A PHP extension returned an error while uploading the file '%value%'" => "Uma extensão do PHP retornou um erro enquanto o arquivo %value% era enviado",
    "File '%value%' was illegally uploaded. This could be a possible attack" => "O arquivo %value% foi enviado ilegalmente. Isto poderia ser um possível ataque",
    "File '%value%' was not found" => "O arquivo %value% não foi encontrado",
    "Unknown error while uploading file '%value%'" => "Erro desconhecido ao enviar o arquivo %value%",

    // Zend\Validator\File\UploadFile
    "File exceeds the defined ini size" => "O arquivo excede o tamanho definido na configuração",
    "File exceeds the defined form size" => "O arquivo excede o tamanho definido do formulário",
    "File was only partially uploaded" => "O arquivo foi apenas parcialmente enviado",
    "File was not uploaded" => "O arquivo não foi enviado",
    "No temporary directory was found for file" => "Nenhum diretório temporário foi encontrado para o arquivo",
    "File can't be written" => "O arquivo não pôde ser escrito",
    "A PHP extension returned an error while uploading the file" => "Uma extensão do PHP retornou um erro enquanto o arquivo era enviado",
    "File was illegally uploaded. This could be a possible attack" => "O arquivo foi enviado ilegalmente. Isto poderia ser um possível ataque",
    "File was not found" => "O arquivo não foi encontrado",
    "Unknown error while uploading file" => "Erro desconhecido ao enviar o arquivo",

    // Zend\Validator\File\WordCount
    "Too many words, maximum '%max%' are allowed but '%count%' were counted" => "Há muitas palavras, são permitidas no máximo '%max%', mas %count% foram contadas",
    "Too few words, minimum '%min%' are expected but '%count%' were counted" => "Há poucas palavras, são esperadas no mínimo '%min%', mas %count% foram contadas",
    "File is not readable or does not exist" => "O arquivo não pode ser lido ou não existe",

    // Zend\Validator\GreaterThan
    "The input is not greater than '%min%'" => "O valor de entrada não é maior do que %min%",
    "The input is not greater or equal than '%min%'" => "O valor de entrada não é maior ou igual a %min%",

    // Zend\Validator\Hex
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser to tipo string",
    "The input contains non-hexadecimal characters" => "O valor de entrada contém caracteres não-hexadecimais",

    // Zend\Validator\Hostname
    "The input appears to be a DNS hostname but the given punycode notation cannot be decoded" => "O valor de entrada parece ser um hostname de DNS, mas a notação punycode fornecida não pode ser decodificada",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser do tipo string",
    "The input appears to be a DNS hostname but contains a dash in an invalid position" => "O valor de entrada parece ser um hostname de DNS, mas contém um traço em uma posição inválida",
    "The input does not match the expected structure for a DNS hostname" => "O valor de entrada não corresponde com a estrutura esperada para um hostname de DNS",
    "The input appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'" => "O valor de entrada parece ser um hostname de DNS, mas não corresponde ao esquema de hostname para o TLD %tld%",
    "The input does not appear to be a valid local network name" => "O valor de entrada não parece ser um nome de rede local válido",
    "The input does not appear to be a valid URI hostname" => "O valor de entrada não parece ser um URI hostname válido",
    "The input appears to be an IP address, but IP addresses are not allowed" => "O valor de entrada parece ser um endereço de IP, mas endereços de IP não são permitidos",
    "The input appears to be a local network name but local network names are not allowed" => "O valor de entrada parece ser um nome de rede local, mas os nomes de rede local não são permitidos",
    "The input appears to be a DNS hostname but cannot extract TLD part" => "O valor de entrada parece ser um hostname de DNS, mas o TLD não pôde ser extraído",
    "The input appears to be a DNS hostname but cannot match TLD against known list" => "O valor de entrada parece ser um hostname de DNS, mas o TLD não corresponde a nenhum TLD conhecido",

    // Zend\Validator\Iban
    "Unknown country within the IBAN" => "País desconhecido para o IBAN",
    "Countries outside the Single Euro Payments Area (SEPA) are not supported" => "Países fora da Área Única de Pagamentos em Euros (SEPA) não são suportados",
    "The input has a false IBAN format" => "O valor de entrada não é um formato IBAN válido",
    "The input has failed the IBAN check" => "O valor de entrada falhou na verificação do IBAN",

    // Zend\Validator\Identical
    "The two given tokens do not match" => "Os valores não conferem",
    "No token was provided to match against" => "Os valores não conferem",

    // Zend\Validator\InArray
    "The input was not found in the haystack" => "O valor de entrada não faz parte dos valores esperados",

    // Zend\Validator\Ip
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",
    "The input does not appear to be a valid IP address" => "O valor de entrada não parece ser um endereço de IP válido",

    // Zend\Validator\IsInstanceOf
    "The input is not an instance of '%className%'" => "O valor de entrada não é uma instância da de %className%",

    // Zend\Validator\Isbn
    "Invalid type given. String or integer expected" => "O tipo especificado é inválido, o valor deve ser string ou inteiro",
    "The input is not a valid ISBN number" => "O valor de entrada não é um número ISBN válido",

    // Zend\Validator\LessThan
    "The input is not less than '%max%'" => "O valor de entrada não é menor do que %max%",
    "The input is not less or equal than '%max%'" => "O valor de entrada não é menor ou igual a %max%",

    // Zend\Validator\NotEmpty
    "Value is required and can't be empty" => "Este campo é obrigatório",
    "Invalid type given. String, integer, float, boolean or array expected" => "O valor informado é inválido",

    // Zend\Validator\Regex
    "Invalid type given. String, integer or float expected" => "O tipo especificado é inválido",
    "The input does not match against pattern '%pattern%'" => "O valor informado é inválido",
    "There was an internal error while using the pattern '%pattern%'" => "Houve um erro com o valor informado",

    // Zend\Validator\Sitemap\Changefreq
    "The input is not a valid sitemap changefreq" => "O valor de entrada não é um changefreq (frequência de alterações) de sitemap válido",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",

    // Zend\Validator\Sitemap\Lastmod
    "The input is not a valid sitemap lastmod" => "O valor de entrada não é um lastmod (última modificação) de sitemap válido",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",

    // Zend\Validator\Sitemap\Loc
    "The input is not a valid sitemap location" => "O valor de entrada não é uma localização de sitemap válida",
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",

    // Zend\Validator\Sitemap\Priority
    "The input is not a valid sitemap priority" => "O valor de entrada não é uma prioridade de sitemap válida",
    "Invalid type given. Numeric string, integer or float expected" => "O tipo especificado é inválido, o valor deve ser um inteiro, um float ou uma string numérica",

    // Zend\Validator\Step
    "Invalid value given. Scalar expected" => "O valor especificado é inválido, o valor deve ser escalar",
    "The input is not a valid step" => "O valor de entrada não é um passo válido",

    // Zend\Validator\StringLength
    "Invalid type given. String expected" => "O tamanho é inválido",
    "The input is less than %min% characters long" => "Deve ter no mínimo %min% caracteres",
    "The input is more than %max% characters long" => "Deve ter no máximo %max% caracteres",

    // Zend\Validator\Timezone
    "Invalid timezone given." => "O fuso horário é inválido",
    "Invalid timezone location given." => "O fuso horário é inválido",
    "Invalid timezone abbreviation given." => "O fuso horário é inválido",

    // Zend\Validator\Uri
    "Invalid type given. String expected" => "O tipo especificado é inválido, o valor deve ser uma string",
    "The input does not appear to be a valid Uri" => "O valor de entrada não parece ser uma Uri válida",
];
