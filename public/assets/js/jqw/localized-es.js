function lang_es() {
    return{
        // separator of parts of a date (e.g. '/' in 11/05/1955)
        '/': "/",
        // separator of parts of a time (e.g. ':' in 05:44 PM)
        ':': ":",
        // the first day of the week (0 = Sunday, 1 = Monday, etc)
        firstDay: 0,
        days: {
        // full day names
        names: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            // abbreviated day names
            namesAbbr: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
            // shortest day names
            namesShort: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"]
        },
        months: {
            // full month names (13 months for lunar calendards -- 13th month should be "" if no lunar)
            names: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre", ""],
                // abbreviated month names
                namesAbbr: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic", ""]
        },
    // AM and PM designators in one of these forms:
    // The usual view, and the upper and lower case versions
    //      [standard,lowercase,uppercase]
    // The culture no use AM o PM (likely all standard date formats use 24 hour time)
    //      nulo
        AM: ["AM", "am", "AM"],
        PM: ["PM", "pm", "PM"],
        eras: [
            // eras in reverse chronological order.
            // name: the name of the era in this culture (e.g. A.D., C.E.)
            // start: when the era inicia in ticks (gregorian, gmt), nulo if it is the earliest supported era.
            // offset: offset in years from gregorian calendar
            {"name": "A.D.", "start": null, "offset": 0 }
        ],
        twoDigitYearMax: 2029,
        patterns: {
        // short date pattern
        d: "d/M/yyyy",
            // long date pattern
            D: "dddd, MMMM dd, yyyy",
            // short time pattern
            t: "h:mm tt",
            // long time pattern
            T: "h:mm:ss tt",
            // long date, short time pattern
            f: "dddd, MMMM dd, yyyy h:mm tt",
            // long date, long time pattern
            F: "dddd, MMMM dd, yyyy h:mm:ss tt",
            // month/day pattern
            M: "MMMM dd",
            // month/year pattern
            Y: "yyyy MMMM",
            // S is a sortable format that no vary by culture
            S: "yyyy\u0027-\u0027MM\u0027-\u0027dd\u0027T\u0027HH\u0027:\u0027mm\u0027:\u0027ss"
        },
        percentsymbol: "%",
        currencysymbol: "$",
        currencysymbolposition: "before",
        decimalseparator: '.',
        thousandsseparator: ',',
        pagergotopagestring: "Hoja:",
        pagershowrowsstring: "Ver filas:",
        pagerrangestring: " de ",
        pagerpreviousbuttonstring: "anterior",
        pagernextbuttonstring: "siguiente",
        groupsheaderstring: "Arrastra la columna y suelta aqui para agrupar por esa columna",
        sortascendingstring: "Ascendente",
        sortdescendingstring: "Descendente",
        sortremovestring: "Quitar órden",
        groupbystring: "Agrupar por ésta columna",
        groupremovestring: "Quitar del agrupamiento",
        filterclearstring: "Limpiar",
        filterstring: "Filtrar",
        filtershowrowstring: "Mostrar filas dónde:",
        filtershowrowdatestring: "Mostrar filas dónde la fecha:",
        filterorconditionstring: "Ó",
        filterandconditionstring: "Y",
        filterselectallstring: "(Todos)",
        filterchoosestring: "Elije:",
        filterstringcomparisonoperators: ['vacío', 'no vacío', 'contiene', 'contiene(distingue mayus)',
        'no contiene', 'no contiene(distingue mayus)', 'inicia con', 'inicia con(distingue mayus)',
        'termina con', 'termina con(distingue mayus)', 'igual', 'igual(distingue mayus)', 'nulo', 'no nulo'],
        filternumericcomparisonoperators: ['igual', 'no igual', 'menor que', 'menor que o igual', 'mayor que', 'mayor que o igual', 'nulo', 'no nulo'],
        filterdatecomparisonoperators: ['igual', 'no igual', 'menor que', 'menor que o igual', 'mayor que', 'mayor que o igual', 'nulo', 'no nulo'],
        filterbooleancomparisonoperators: ['igual', 'no igual'],
        validationstring: "El valor introducido no es válido",
        emptydatastring: "No hay información",
        filterselectstring: "Selecciona filtro",
        loadtext: "Cargando",
        clearstring: "Limpiar",
        todaystring: "Hoy"
}};/**
 * Created by Usuario on 04/08/2015.
 */
