<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute must be accepted.",//":attribute musi zostać zaakceptowane.",
	"active_url"           => "The :attribute is not a valid URL.",//":attribute nie jest poprawnym adresem URL.",
	"after"                => "The :attribute must be a date after :date.",//":attribute musi być datą po :date.",
	"alpha"                => "The :attribute may only contain letters.",//":attribute może zawierać tylko litery.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",//":attribute może zawierać tylko litery, cyfry i kreski.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",//":attribute może zawierać tylko litery i cyfry.",
	"array"                => "The :attribute must be an array.",//":attribute musi być tablicą.",
	"before"               => "The :attribute must be a date before :date.",//":attribute musi być datą sprzed :date.",
	"between"              => [
		"numeric" => "The :attribute must be between :min and :max.",//":attribute musi być między :min a :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",//"Rozmiar :attribute musi być między :min a :max kilobajtów.",
		"string"  => "The :attribute must be between :min and :max characters.",//"Długość :attribute musi być między :min a :max znaków.",
		"array"   => "The :attribute must have between :min and :max items.",//":attribute musi mieć między :min a :max elementów.",
	],
	"boolean"              => "The :attribute field must be true or false.",//":attribute musi mieć wartość true lub false.",
	"confirmed"            => "The :attribute confirmation does not match.",//"Potwierdzenie :attribute się nie zgadza.",
	"date"                 => "The :attribute is not a valid date.",//":attribute nie jest poprawną datą.",
	"date_format"          => "The :attribute does not match the format :format.",//":attribute nie pasuje do formatu :format.",
	"different"            => "The :attribute and :other must be different.",//":attribute oraz :other muszą być różne.",
	"digits"               => "The :attribute must be :digits digits.",//":attribute musi mieć :digits cyfr.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",//"Długość :attribute musi się mieścić między :min a :max cyframi.",
	"email"                => "The :attribute must be a valid email address.",//":attribute musi być poprawnym adresem email.",
	"filled"               => "The :attribute field is required.",//"Pole :attribute jest niepoprawne.",
	"exists"               => "The selected :attribute is invalid.",//"Wybrany :attribute jest niepoprawny.",
	"image"                => "The :attribute must be an image.",//":attribute musi być obrazkiem.",
	"in"                   => "The selected :attribute is invalid.",//":attribute jest niepoprawny.",
	"integer"              => "The :attribute must be an integer.",//":attribute musi być liczbą całkowitą.",
	"ip"                   => "The :attribute must be a valid IP address.",//":attribute musi być poprawnym adresem IP.",
	"max"                  => [
		"numeric" => "The :attribute may not be greater than :max.",//":attribute musi mieć długość co najwyżej :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",//":attribute musi mieć co najwyżej :max kilobajtów.",
		"string"  => "The :attribute may not be greater than :max characters.",//":attribute musi mieć długość co najwyżej :max znaków.",
		"array"   => "The :attribute may not have more than :max items.",//":attribute musi mieć co najwyżej :max elementów.",
	],
	"mimes"                => "The :attribute must be a file of type: :values.",//":attribute musi być plikiem typu: :values.",
	"min"                  => [
		"numeric" => "The :attribute must be at least :min.",//":attribute musi mieć długość co najmniej :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",//":attribute musi mieć co najmniej :min kilobajtów.",
		"string"  => "The :attribute must be at least :min characters.",//":attribute musi mieć długość co najmniej :min znaków.",
		"array"   => "The :attribute must have at least :min items.",//":attribute musi mieć co najmnniej :min elementów.",
	],
	"not_in"               => "The selected :attribute is invalid.",//"Wybrana wartość :attribute jest niepoprawna.",
	"numeric"              => "The :attribute must be a number.",//":attribute musi być liczbą.",
	"regex"                => "The :attribute format is invalid.",//"Format :attribute jest niepoprawny.",
	"required"             => "The :attribute field is required.",//"Pole :attribute jest wymagane.",
	"required_if"          => "The :attribute field is required when :other is :value.",//"Pole :attribute jest wymagane, gdy pole :other zawiera :value.",
	"required_with"        => "The :attribute field is required when :values is present.",//"Pole :attribute jest wymagane, gdy któreś z pól :values jest wypełnione.",
	"required_with_all"    => "The :attribute field is required when :values is present.",//"Pole :attribute jest wymagane, gdy pola :values są wypełnione.",
	"required_without"     => "The :attribute field is required when :values is not present.",//"Pole :attribute jest wymagane, gdy pole :values nie jest wypełnione.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",//"Pole :attribute jest wymagane, gdy żadne z pól :values nie jest wypełnione.",
	"same"                 => "The :attribute and :other must match.",//":attribute oraz :other muszą się zgadzać.",
	"size"                 => [
		"numeric" => "The :attribute must be :size.",//":attribute musi mieć rozmiar :size.",
		"file"    => "The :attribute must be :size kilobytes.",//":attribute musi mieć rozmiar :size kilobajtów.",
		"string"  => "The :attribute must be :size characters.",//":attribute musi mieć długość :size znaków.",
		"array"   => "The :attribute must contain :size items.",//":attribute musi zawierać :size elementów.",
	],
	"unique"               => "The :attribute has already been taken.",//":attribute jest już zajęty.",
	"url"                  => "The :attribute format is invalid.",//"Format :attribute jest niepoprawny.",
	"timezone"             => "The :attribute must be a valid zone.",//":attribute musi być poprawną strefą czasową.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
		'major-general' => [
			'required' => "You need a very model of a modern Major-General in order to establish a new colony.",//"Potrzebujesz prawdziwego wzorca współczesnego Majora-Generała, by założyć nową kolonię.",
			'min' => "You need a very model of a modern Major-General in order to establish a new colony.",//"Potrzebujesz prawdziwego wzorca współczesnego Majora-Generała, by założyć nową kolonię.",
			'max' => "Good Lord, one Major-General is enough.",//"Dobry Panie, jeden Major-Generał wystarczy.",
		],
		'newport' => [
			'required' => 'Arrr! Ye can\'t settle down a new port with no name, ye land rat!',//"Arr! Nie możesz założyć nowego portu bez nadania mu nazwy, ty szczurze lądowy!",
			'unique' => 'Arrr! This port name be already taken.'//"Arr! Nazwa portu \':attribute\' jest już zajęta.",
		],
		'nazwa' => [
			'unique' => 'This port name has been already taken.',//"Nazwa portu \':attribute\' jest już zajęta.",
			'wolne_miejsce' => 'All islands are already taken. You cannot register on this server.'//'Wszystkie wyspy są zajęte. Nie możesz się zarejestrować na tym serwerze.'
		],
		'atak_jednostki' => [
			'max' => 'You can\'t send more units than you own.',//'Nie możesz wysłać więcej jednostek niż posiadasz',
			'min' => 'You need to send at least one unit in order to perform an attack.',//'Musisz wysłać przynajmniej jedną jednostkę, aby przeprowadzić atak'
			'alone' => 'Good Lord, if you send Major-Generals without any escort, they will die a horrible and pointless death.'
		],
		'amount' => [
			'min' => 'You can\'t send a negative number of units.',
		],		
		'budynek' => [
			"not_enough" => "There are not enough resources in the port to build ",//"W porcie jest za mało surowców, by móc zbudować ",
		],
		'jednostka' => [
			"not_enough" => "There are not enough resources in the port to recruit ",//"W porcie jest za mało surowców, by móc zwerbować ",
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
