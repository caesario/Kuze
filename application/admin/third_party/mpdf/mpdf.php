<?php

// ******************************************************************************
// Software: mPDF, Unicode-HTML Free PDF generator                              *
// Version:  5.7.4     based on                                                 *
//           FPDF by Olivier PLATHEY                                            *
//           HTML2FPDF by Renato Coelho                                         *
// Date:     2014-08-23                                                         *
// Author:   Ian Back <ianb@bpm1.com>                                           *
// License:  GPL                                                                *
//                                                                              *
// Changes:  See changelog.txt                                                  *
// ******************************************************************************


define('mPDF_VERSION', '5.7.4');

//Scale factor
define('_MPDFK', (72 / 25.4));

/*-- HTML-CSS --*/
define('AUTOFONT_CJK', 1);
define('AUTOFONT_THAIVIET', 2);
define('AUTOFONT_RTL', 4);
define('AUTOFONT_INDIC', 8);
define('AUTOFONT_ALL', 15);

define('_BORDER_ALL', 15);
define('_BORDER_TOP', 8);
define('_BORDER_RIGHT', 4);
define('_BORDER_BOTTOM', 2);
define('_BORDER_LEFT', 1);
/*-- END HTML-CSS --*/

if (!defined('_MPDF_PATH')) define('_MPDF_PATH', dirname(preg_replace('/\\\\/', '/', __FILE__)) . '/');
if (!defined('_MPDF_URI')) define('_MPDF_URI', _MPDF_PATH);

require_once(_MPDF_PATH . 'includes/functions.php');
require_once(_MPDF_PATH . 'config_cp.php');

if (!defined('_JPGRAPH_PATH')) define("_JPGRAPH_PATH", _MPDF_PATH . 'jpgraph/');

if (!defined('_MPDF_TEMP_PATH')) define("_MPDF_TEMP_PATH", _MPDF_PATH . 'tmp/');

if (!defined('_MPDF_TTFONTPATH')) {
    define('_MPDF_TTFONTPATH', _MPDF_PATH . 'ttfonts/');
}
if (!defined('_MPDF_TTFONTDATAPATH')) {
    define('_MPDF_TTFONTDATAPATH', _MPDF_PATH . 'ttfontdata/');
}

$errorlevel = error_reporting();
$errorlevel = error_reporting($errorlevel & ~E_NOTICE);

//error_reporting(E_ALL);

if (function_exists("date_default_timezone_set")) {
    if (ini_get("date.timezone") == "") {
        date_default_timezone_set("Europe/London");
    }
}
if (!function_exists("mb_strlen")) {
    die("Error - mPDF requires mb_string functions. Ensure that PHP is compiled with php_mbstring.dll enabled.");
}

if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
// Machine dependent number of bytes used to pack "double" into binary (used in cacheTables)
$test = pack("d", 134455.474557333333666);
define("_DSIZE", strlen($test));

class mPDF
{

///////////////////////////////
// EXTERNAL (PUBLIC) VARIABLES
// Define these in config.php
///////////////////////////////
    var $CJKforceend;    // mPDF 5.6.40
// mPDF 5.6.34
    var $h2bookmarks;
    var $h2toc;
    var $decimal_align;    // mPDF 5.6.13
    var $margBuffer;    // mPDF 5.4.04
    var $splitTableBorderWidth;    // mPDF 5.4.16

    var $cacheTables;
    var $bookmarkStyles;
    var $useActiveForms;

    var $repackageTTF;
    var $allowCJKorphans;
    var $allowCJKoverflow;

    var $useKerning;
    var $restrictColorSpace;
    var $bleedMargin;
    var $crossMarkMargin;
    var $cropMarkMargin;
    var $cropMarkLength;
    var $nonPrintMargin;

    var $PDFX;
    var $PDFXauto;

    var $PDFA;
    var $PDFAauto;
    var $ICCProfile;

    var $printers_info;
    var $iterationCounter;
    var $smCapsScale;
    var $smCapsStretch;

    var $backupSubsFont;
    var $backupSIPFont;
    var $debugfonts;
    var $useAdobeCJK;
    var $percentSubset;
    var $maxTTFFilesize;
    var $BMPonly;

    var $tableMinSizePriority;

    var $dpi;
    var $watermarkImgAlphaBlend;
    var $watermarkImgBehind;
    var $justifyB4br;
    var $packTableData;
    var $pgsIns;
    var $simpleTables;
    var $enableImports;

    var $debug;
    var $showStats;
    var $setAutoTopMargin;
    var $setAutoBottomMargin;
    var $autoMarginPadding;
    var $collapseBlockMargins;
    var $falseBoldWeight;
    var $normalLineheight;
    var $progressBar;
    var $incrementFPR1;
    var $incrementFPR2;
    var $incrementFPR3;
    var $incrementFPR4;

    var $SHYlang;
    var $SHYleftmin;
    var $SHYrightmin;
    var $SHYcharmin;
    var $SHYcharmax;
    var $SHYlanguages;
// PageNumber Conditional Text
    var $pagenumPrefix;
    var $pagenumSuffix;
    var $nbpgPrefix;
    var $nbpgSuffix;
    var $showImageErrors;
    var $allow_output_buffering;
    var $autoPadding;
    var $useGraphs;
    var $autoFontGroupSize;
    var $tabSpaces;
    var $useLang;
    var $restoreBlockPagebreaks;
    var $watermarkTextAlpha;
    var $watermarkImageAlpha;
    var $watermark_size;
    var $watermark_pos;
    var $annotSize;
    var $annotMargin;
    var $annotOpacity;
    var $title2annots;
    var $keepColumns;
    var $keep_table_proportions;
    var $ignore_table_widths;
    var $ignore_table_percents;
    var $list_align_style;
    var $list_number_suffix;
    var $useSubstitutions;
    var $CSSselectMedia;

    var $forcePortraitHeaders;
    var $forcePortraitMargins;
    var $displayDefaultOrientation;
    var $ignore_invalid_utf8;
    var $allowedCSStags;
    var $onlyCoreFonts;
    var $allow_charset_conversion;

    var $jSWord;
    var $jSmaxChar;
    var $jSmaxCharLast;
    var $jSmaxWordLast;

    var $max_colH_correction;


    var $table_error_report;
    var $table_error_report_param;
    var $biDirectional;
    var $text_input_as_HTML;
    var $anchor2Bookmark;
    var $list_indent_first_level;
    var $shrink_tables_to_fit;

    var $allow_html_optional_endtags;

    var $img_dpi;

    var $defaultheaderfontsize;
    var $defaultheaderfontstyle;
    var $defaultheaderline;
    var $defaultfooterfontsize;
    var $defaultfooterfontstyle;
    var $defaultfooterline;
    var $header_line_spacing;
    var $footer_line_spacing;

    var $pregUHCchars;
    var $pregSJISchars;
    var $pregCJKchars;
    var $pregASCIIchars1;
    var $pregASCIIchars2;
    var $pregASCIIchars3;
    var $pregVIETchars;
    var $pregVIETPluschars;

    var $pregRTLchars;
    var $pregHEBchars;
    var $pregARABICchars;
    var $pregNonARABICchars;
// INDIC
    var $pregHIchars;
    var $pregBNchars;
    var $pregPAchars;
    var $pregGUchars;
    var $pregORchars;
    var $pregTAchars;
    var $pregTEchars;
    var $pregKNchars;
    var $pregMLchars;
    var $pregSHchars;
    var $pregINDextra;

    var $mirrorMargins;
    var $default_lineheight_correction;
    var $watermarkText;
    var $watermarkImage;
    var $showWatermarkText;
    var $showWatermarkImage;

    var $fontsizes;

// Aliases for backward compatability
    var $UnvalidatedText;    // alias = $watermarkText
    var $TopicIsUnvalidated;    // alias = $showWatermarkText
    var $useOddEven;        // alias = $mirrorMargins
    var $useSubstitutionsMB;    // alias = $useSubstitutions


//////////////////////
// CLASS OBJECTS
//////////////////////
    var $cssmgr;
    var $grad;
    var $bmp;
    var $wmf;
    var $tocontents;
    var $form;
    var $directw;

//////////////////////
// INTERNAL VARIABLES
//////////////////////
    var $uniqstr;    // mPDF 5.7.2
    var $writingToC;    // mPDF 5.6.38
// mPDF 5.6.01
    var $layers;
    var $current_layer;
    var $open_layer_pane;
    var $decimal_offset;    // mPDF 5.6.13
    var $inMeter;    // mPDF 5.5.09

    var $CJKleading;
    var $CJKfollowing;
    var $CJKoverflow;

    var $textshadow;

    var $colsums;
    var $spanborder;
    var $spanborddet;

    var $visibility;

    var $useRC128encryption;
    var $uniqid;

    var $kerning;
    var $fixedlSpacing;
    var $minwSpacing;
    var $lSpacingCSS;
    var $wSpacingCSS;

    var $listDir;
    var $spotColorIDs;
    var $SVGcolors;
    var $spotColors;
    var $defTextColor;
    var $defDrawColor;
    var $defFillColor;

    var $tableBackgrounds;
    var $inlineDisplayOff;
    var $kt_y00;
    var $kt_p00;
    var $upperCase;
    var $checkSIP;
    var $checkSMP;
    var $checkCJK;
    var $tableCJK;

    var $watermarkImgAlpha;
    var $PDFAXwarnings;
    var $MetadataRoot;
    var $OutputIntentRoot;
    var $InfoRoot;
    var $current_filename;
    var $parsers;
    var $current_parser;
    var $_obj_stack;
    var $_don_obj_stack;
    var $_current_obj_id;
    var $tpls;
    var $tpl;
    var $tplprefix;
    var $_res;

    var $pdf_version;
    var $noImageFile;
    var $lastblockbottommargin;
    var $baselineC;
// mPDF 5.7.3  inline text-decoration parameters
    var $baselineSup;
    var $baselineSub;
    var $baselineS;
    var $subPos;
    var $subArrMB;
    var $ReqFontStyle;
    var $tableClipPath;
    var $forceExactLineheight;
    var $listOcc;

    var $fullImageHeight;
    var $inFixedPosBlock;        // Internal flag for position:fixed block
    var $fixedPosBlock;        // Buffer string for position:fixed block
    var $fixedPosBlockDepth;
    var $fixedPosBlockBBox;
    var $fixedPosBlockSave;
    var $maxPosL;
    var $maxPosR;

    var $loaded;

    var $extraFontSubsets;
    var $docTemplateStart;        // Internal flag for page (page no. -1) that docTemplate starts on
    var $time0;

// Classes
    var $indic;
    var $barcode;

    var $SHYpatterns;
    var $loadedSHYpatterns;
    var $loadedSHYdictionary;
    var $SHYdictionary;
    var $SHYdictionaryWords;

    var $spanbgcolorarray;
    var $default_font;
    var $list_lineheight;
    var $headerbuffer;
    var $lastblocklevelchange;
    var $nestedtablejustfinished;
    var $linebreakjustfinished;
    var $cell_border_dominance_L;
    var $cell_border_dominance_R;
    var $cell_border_dominance_T;
    var $cell_border_dominance_B;
    var $table_keep_together;
    var $plainCell_properties;
    var $inherit_lineheight;
    var $listitemtype;
    var $shrin_k1;
    var $outerfilled;

    var $blockContext;
    var $floatDivs;


    var $patterns;
    var $pageBackgrounds;

    var $bodyBackgroundGradient;
    var $bodyBackgroundImage;
    var $bodyBackgroundColor;

    var $writingHTMLheader;    // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
    var $writingHTMLfooter;
    var $autoFontGroups;
    var $angle;

    var $gradients;

    var $kwt_Reference;
    var $kwt_BMoutlines;
    var $kwt_toc;

    var $tbrot_Reference;
    var $tbrot_BMoutlines;
    var $tbrot_toc;

    var $col_Reference;
    var $col_BMoutlines;
    var $col_toc;

    var $currentGraphId;
    var $graphs;

    var $floatbuffer;
    var $floatmargins;

    var $bullet;
    var $bulletarray;

    var $rtlAsArabicFarsi;        // DEPRACATED

    var $currentLang;
    var $default_lang;
    var $default_available_fonts;
    var $pageTemplate;
    var $docTemplate;
    var $docTemplateContinue;

    var $arabGlyphs;
    var $arabHex;
    var $persianGlyphs;
    var $persianHex;
    var $arabVowels;
    var $arabPrevLink;
    var $arabNextLink;


    var $formobjects; // array of Form Objects for WMF
    var $InlineProperties;
    var $InlineAnnots;
    var $ktAnnots;
    var $tbrot_Annots;
    var $kwt_Annots;
    var $columnAnnots;
    var $columnForms;

    var $PageAnnots;

    var $pageDim;    // Keep track of page wxh for orientation changes - set in _beginpage, used in _putannots

    var $breakpoints;

    var $tableLevel;
    var $tbctr;
    var $innermostTableLevel;
    var $saveTableCounter;
    var $cellBorderBuffer;

    var $saveHTMLFooter_height;
    var $saveHTMLFooterE_height;

    var $firstPageBoxHeader;
    var $firstPageBoxHeaderEven;
    var $firstPageBoxFooter;
    var $firstPageBoxFooterEven;

    var $page_box;
    var $show_marks;    // crop or cross marks

    var $basepathIsLocal;

    var $use_kwt;
    var $kwt;
    var $kwt_height;
    var $kwt_y0;
    var $kwt_x0;
    var $kwt_buffer;
    var $kwt_Links;
    var $kwt_moved;
    var $kwt_saved;

    var $PageNumSubstitutions;

    var $table_borders_separate;
    var $base_table_properties;
    var $borderstyles;

    var $listjustfinished;
    var $blockjustfinished;

    var $orig_bMargin;
    var $orig_tMargin;
    var $orig_lMargin;
    var $orig_rMargin;
    var $orig_hMargin;
    var $orig_fMargin;

    var $pageheaders;
    var $pagefooters;

    var $pageHTMLheaders;
    var $pageHTMLfooters;

    var $saveHTMLHeader;
    var $saveHTMLFooter;

    var $HTMLheaderPageLinks;
    var $HTMLheaderPageAnnots;
    var $HTMLheaderPageForms;

// See config_fonts.php for these next 5 values
    var $available_unifonts;
    var $sans_fonts;
    var $serif_fonts;
    var $mono_fonts;
    var $defaultSubsFont;

// List of ALL available CJK fonts (incl. styles) (Adobe add-ons)  hw removed
    var $available_CJK_fonts;

    var $HTMLHeader;
    var $HTMLFooter;
    var $HTMLHeaderE;
    var $HTMLFooterE;
    var $bufferoutput;

    var $showdefaultpagenos;    // DEPRACATED -left for backward compatability


// CJK fonts
    var $Big5_widths;
    var $GB_widths;
    var $SJIS_widths;
    var $UHC_widths;

// SetProtection
    var $encrypted;    //whether document is protected
    var $Uvalue;    //U entry in pdf document
    var $Ovalue;    //O entry in pdf document
    var $Pvalue;    //P entry in pdf document
    var $enc_obj_id;    //encryption object id
    var $last_rc4_key;    //last RC4 key encrypted (cached for optimisation)
    var $last_rc4_key_c;    //last RC4 computed key
    var $encryption_key;
    var $padding;    //used for encryption


// Bookmark
    var $BMoutlines;
    var $OutlineRoot;
// INDEX
    var $ColActive;
    var $Reference;
    var $CurrCol;
    var $NbCol;
    var $y0;            //Top ordinate of columns
    var $ColL;
    var $ColWidth;
    var $ColGap;
// COLUMNS
    var $ColR;
    var $ChangeColumn;
    var $columnbuffer;
    var $ColDetails;
    var $columnLinks;
    var $colvAlign;
// Substitutions
    var $substitute;        // Array of substitution strings e.g. <ttz>112</ttz>
    var $entsearch;        // Array of HTML entities (>ASCII 127) to substitute
    var $entsubstitute;    // Array of substitution decimal unicode for the Hi entities


// Default values if no style sheet offered	(cf. http://www.w3.org/TR/CSS21/sample.html)
    var $defaultCSS;

    var $linemaxfontsize;
    var $lineheight_correction;
    var $lastoptionaltag;    // Save current block item which HTML specifies optionsl endtag
    var $pageoutput;
    var $charset_in;
    var $blk;
    var $blklvl;
    var $ColumnAdjust;
    var $ws;    // Word spacing
    var $HREF;
    var $pgwidth;
    var $fontlist;
    var $oldx;
    var $oldy;
    var $B;
    var $U;      //underlining flag
    var $S;    // SmallCaps flag
    var $I;

    var $tdbegin;
    var $table;
    var $cell;
    var $col;
    var $row;

    var $divbegin;
    var $divalign;
    var $divwidth;
    var $divheight;
    var $divrevert;
    var $spanbgcolor;

    var $listlvl;
    var $listnum;
    var $listtype;
    var $listoccur;
    var $listlist;
    var $listitem;

    var $pjustfinished;
    var $ignorefollowingspaces;
    var $SUP;
    var $SUB;
    var $SMALL;
    var $BIG;
    var $toupper;
    var $tolower;
    var $capitalize;
    var $dash_on;
    var $dotted_on;
    var $strike;

    var $textbuffer;
    var $currentfontstyle;
    var $currentfontfamily;
    var $currentfontsize;
    var $colorarray;
    var $bgcolorarray;
    var $internallink;
    var $enabledtags;

    var $lineheight;
    var $basepath;
    var $textparam;

    var $specialcontent;
    var $selectoption;
    var $objectbuffer;

// Table Rotation
    var $table_rotate;
    var $tbrot_maxw;
    var $tbrot_maxh;
    var $tablebuffer;
    var $tbrot_align;
    var $tbrot_Links;

    var $divbuffer;        // Buffer used when keeping DIV on one page
    var $keep_block_together;    // Keep a Block from page-break-inside: avoid
    var $ktLinks;        // Keep-together Block links array
    var $ktBlock;        // Keep-together Block array
    var $ktForms;
    var $ktReference;
    var $ktBMoutlines;
    var $_kttoc;

    var $tbrot_y0;
    var $tbrot_x0;
    var $tbrot_w;
    var $tbrot_h;

    var $mb_enc;
    var $directionality;

    var $extgstates; // Used for alpha channel - Transparency (Watermark)
    var $mgl;
    var $mgt;
    var $mgr;
    var $mgb;

    var $tts;
    var $ttz;
    var $tta;

    var $headerDetails;
    var $footerDetails;

// Best to alter the below variables using default stylesheet above
    var $page_break_after_avoid;
    var $margin_bottom_collapse;
    var $list_indent;
    var $list_align;
    var $list_margin_bottom;
    var $default_font_size;    // in pts
    var $original_default_font_size;    // used to save default sizes when using table default
    var $original_default_font;
    var $watermark_font;
    var $defaultAlign;

// TABLE
    var $defaultTableAlign;
    var $tablethead;
    var $thead_font_weight;
    var $thead_font_style;
    var $thead_font_smCaps;
    var $thead_valign_default;
    var $thead_textalign_default;
    var $tabletfoot;
    var $tfoot_font_weight;
    var $tfoot_font_style;
    var $tfoot_font_smCaps;
    var $tfoot_valign_default;
    var $tfoot_textalign_default;

    var $trow_text_rotate;

    var $cellPaddingL;
    var $cellPaddingR;
    var $cellPaddingT;
    var $cellPaddingB;
    var $table_lineheight;
    var $table_border_attr_set;
    var $table_border_css_set;

    var $shrin_k;            // factor with which to shrink tables - used internally - do not change
    var $shrink_this_table_to_fit;    // 0 or false to disable; value (if set) gives maximum factor to reduce fontsize
    var $MarginCorrection;    // corrects for OddEven Margins
    var $margin_footer;
    var $margin_header;

    var $tabletheadjustfinished;
    var $usingCoreFont;
    var $charspacing;

//Private properties FROM FPDF
    var $DisplayPreferences;
    var $flowingBlockAttr;
    var $page;               //current page number
    var $n;                  //current object number
    var $offsets;            //array of object offsets
    var $buffer;             //buffer holding in-memory PDF
    var $pages;              //array containing pages
    var $state;              //current document state
    var $compress;           //compression flag
    var $DefOrientation;     //default orientation
    var $CurOrientation;     //current orientation
    var $OrientationChanges; //array indicating orientation changes
    var $k;                  //scale factor (number of points in user unit)
    var $fwPt;
    var $fhPt;         //dimensions of page format in points
    var $fw;
    var $fh;             //dimensions of page format in user unit
    var $wPt;
    var $hPt;           //current dimensions of page in points
    var $w;
    var $h;               //current dimensions of page in user unit
    var $lMargin;            //left margin
    var $tMargin;            //top margin
    var $rMargin;            //right margin
    var $bMargin;            //page break margin
    var $cMarginL;            //cell margin Left
    var $cMarginR;            //cell margin Right
    var $cMarginT;            //cell margin Left
    var $cMarginB;            //cell margin Right
    var $DeflMargin;            //Default left margin
    var $DefrMargin;            //Default right margin
    var $x;
    var $y;               //current position in user unit for cell positioning
    var $lasth;              //height of last cell printed
    var $LineWidth;          //line width in user unit
    var $CoreFonts;          //array of standard font names
    var $fonts;              //array of used fonts
    var $FontFiles;          //array of font files
    var $images;             //array of used images
    var $PageLinks;          //array of links in pages
    var $links;              //array of internal links
    var $FontFamily;         //current font family
    var $FontStyle;          //current font style
    var $CurrentFont;        //current font info
    var $FontSizePt;         //current font size in points
    var $FontSize;           //current font size in user unit
    var $DrawColor;          //commands for drawing color
    var $FillColor;          //commands for filling color
    var $TextColor;          //commands for text color
    var $ColorFlag;          //indicates whether fill and text colors are different
    var $autoPageBreak;      //automatic page breaking
    var $PageBreakTrigger;   //threshold used to trigger page breaks
    var $InFooter;           //flag set when processing footer
    var $InHTMLFooter;

    var $processingFooter;   //flag set when processing footer - added for columns
    var $processingHeader;   //flag set when processing header - added for columns
    var $ZoomMode;           //zoom display mode
    var $LayoutMode;         //layout display mode
    var $title;              //title
    var $subject;            //subject
    var $author;             //author
    var $keywords;           //keywords
    var $creator;            //creator

    var $aliasNbPg;       //alias for total number of pages
    var $aliasNbPgGp;       //alias for total number of pages in page group
    var $aliasNbPgHex;
    var $aliasNbPgGpHex;

    var $ispre;

    var $outerblocktags;
    var $innerblocktags;


// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************
// **********************************

    function __construct($mode = '', $format = 'A4', $default_font_size = 0, $default_font = '', $mgl = 15, $mgr = 15, $mgt = 16, $mgb = 16, $mgh = 9, $mgf = 9, $orientation = 'P')
    {

        /*-- BACKGROUNDS --*/
        if (!class_exists('grad', false)) {
            include(_MPDF_PATH . 'classes/grad.php');
        }
        if (empty($this->grad)) {
            $this->grad = new grad($this);
        }
        /*-- END BACKGROUNDS --*/
        /*-- FORMS --*/
        if (!class_exists('form', false)) {
            include(_MPDF_PATH . 'classes/form.php');
        }
        if (empty($this->form)) {
            $this->form = new form($this);
        }
        /*-- END FORMS --*/

        $this->time0 = microtime(true);
        //Some checks
        $this->_dochecks();

        // Set up Aliases for backwards compatability
        $this->UnvalidatedText =& $this->watermarkText;
        $this->TopicIsUnvalidated =& $this->showWatermarkText;
        $this->AliasNbPg =& $this->aliasNbPg;
        $this->AliasNbPgGp =& $this->aliasNbPgGp;
        $this->BiDirectional =& $this->biDirectional;
        $this->Anchor2Bookmark =& $this->anchor2Bookmark;
        $this->KeepColumns =& $this->keepColumns;
        $this->useOddEven =& $this->mirrorMargins;
        $this->useSubstitutionsMB =& $this->useSubstitutions;

        $this->writingToC = false;    // mPDF 5.6.38
        $this->uniqstr = '20110230';    // mPDF 5.7.2
        // mPDF 5.6.01
        $this->layers = array();
        $this->current_layer = 0;
        $this->open_layer_pane = false;

        $this->visibility = 'visible';

        //Initialization of properties
        $this->spotColors = array();
        $this->spotColorIDs = array();
        $this->tableBackgrounds = array();

        $this->kt_y00 = '';
        $this->kt_p00 = '';
        $this->iterationCounter = false;
        $this->BMPonly = array();
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->objectbuffer = array();
        $this->pages = array();
        $this->OrientationChanges = array();
        $this->state = 0;
        $this->fonts = array();
        $this->FontFiles = array();
        $this->images = array();
        $this->links = array();
        $this->InFooter = false;
        $this->processingFooter = false;
        $this->processingHeader = false;
        $this->lasth = 0;
        $this->FontFamily = '';
        $this->FontStyle = '';
        $this->FontSizePt = 9;
        $this->U = false;
        // Small Caps
        $this->upperCase = array();
        $this->S = false;
        $this->smCapsScale = 1;
        $this->smCapsStretch = 100;
        $this->margBuffer = 0;    // mPDF 5.4.04
        $this->inMeter = false;    // mPDF 5.5.09
        $this->decimal_offset = 0;

        $this->defTextColor = $this->TextColor = $this->SetTColor($this->ConvertColor(0), true);
        $this->defDrawColor = $this->DrawColor = $this->SetDColor($this->ConvertColor(0), true);
        $this->defFillColor = $this->FillColor = $this->SetFColor($this->ConvertColor(255), true);

        //SVG color names array
        //http://www.w3schools.com/css/css_colornames.asp
        $this->SVGcolors = array('antiquewhite' => '#FAEBD7', 'aqua' => '#00FFFF', 'aquamarine' => '#7FFFD4', 'beige' => '#F5F5DC', 'black' => '#000000',
            'blue' => '#0000FF', 'brown' => '#A52A2A', 'cadetblue' => '#5F9EA0', 'chocolate' => '#D2691E', 'cornflowerblue' => '#6495ED', 'crimson' => '#DC143C',
            'darkblue' => '#00008B', 'darkgoldenrod' => '#B8860B', 'darkgreen' => '#006400', 'darkmagenta' => '#8B008B', 'darkorange' => '#FF8C00',
            'darkred' => '#8B0000', 'darkseagreen' => '#8FBC8F', 'darkslategray' => '#2F4F4F', 'darkviolet' => '#9400D3', 'deepskyblue' => '#00BFFF',
            'dodgerblue' => '#1E90FF', 'firebrick' => '#B22222', 'forestgreen' => '#228B22', 'fuchsia' => '#FF00FF', 'gainsboro' => '#DCDCDC', 'gold' => '#FFD700',
            'gray' => '#808080', 'green' => '#008000', 'greenyellow' => '#ADFF2F', 'hotpink' => '#FF69B4', 'indigo' => '#4B0082', 'khaki' => '#F0E68C',
            'lavenderblush' => '#FFF0F5', 'lemonchiffon' => '#FFFACD', 'lightcoral' => '#F08080', 'lightgoldenrodyellow' => '#FAFAD2', 'lightgreen' => '#90EE90',
            'lightsalmon' => '#FFA07A', 'lightskyblue' => '#87CEFA', 'lightslategray' => '#778899', 'lightyellow' => '#FFFFE0', 'lime' => '#00FF00', 'limegreen' => '#32CD32',
            'magenta' => '#FF00FF', 'maroon' => '#800000', 'mediumaquamarine' => '#66CDAA', 'mediumorchid' => '#BA55D3', 'mediumseagreen' => '#3CB371',
            'mediumspringgreen' => '#00FA9A', 'mediumvioletred' => '#C71585', 'midnightblue' => '#191970', 'mintcream' => '#F5FFFA', 'moccasin' => '#FFE4B5', 'navy' => '#000080',
            'olive' => '#808000', 'orange' => '#FFA500', 'orchid' => '#DA70D6', 'palegreen' => '#98FB98',
            'palevioletred' => '#D87093', 'peachpuff' => '#FFDAB9', 'pink' => '#FFC0CB', 'powderblue' => '#B0E0E6', 'purple' => '#800080',
            'red' => '#FF0000', 'royalblue' => '#4169E1', 'salmon' => '#FA8072', 'seagreen' => '#2E8B57', 'sienna' => '#A0522D', 'silver' => '#C0C0C0', 'skyblue' => '#87CEEB',
            'slategray' => '#708090', 'springgreen' => '#00FF7F', 'steelblue' => '#4682B4', 'tan' => '#D2B48C', 'teal' => '#008080', 'thistle' => '#D8BFD8', 'turquoise' => '#40E0D0',
            'violetred' => '#D02090', 'white' => '#FFFFFF', 'yellow' => '#FFFF00',
            'aliceblue' => '#f0f8ff', 'azure' => '#f0ffff', 'bisque' => '#ffe4c4', 'blanchedalmond' => '#ffebcd', 'blueviolet' => '#8a2be2', 'burlywood' => '#deb887',
            'chartreuse' => '#7fff00', 'coral' => '#ff7f50', 'cornsilk' => '#fff8dc', 'cyan' => '#00ffff', 'darkcyan' => '#008b8b', 'darkgray' => '#a9a9a9',
            'darkgrey' => '#a9a9a9', 'darkkhaki' => '#bdb76b', 'darkolivegreen' => '#556b2f', 'darkorchid' => '#9932cc', 'darksalmon' => '#e9967a',
            'darkslateblue' => '#483d8b', 'darkslategrey' => '#2f4f4f', 'darkturquoise' => '#00ced1', 'deeppink' => '#ff1493', 'dimgray' => '#696969',
            'dimgrey' => '#696969', 'floralwhite' => '#fffaf0', 'ghostwhite' => '#f8f8ff', 'goldenrod' => '#daa520', 'grey' => '#808080', 'honeydew' => '#f0fff0',
            'indianred' => '#cd5c5c', 'ivory' => '#fffff0', 'lavender' => '#e6e6fa', 'lawngreen' => '#7cfc00', 'lightblue' => '#add8e6', 'lightcyan' => '#e0ffff',
            'lightgray' => '#d3d3d3', 'lightgrey' => '#d3d3d3', 'lightpink' => '#ffb6c1', 'lightseagreen' => '#20b2aa', 'lightslategrey' => '#778899',
            'lightsteelblue' => '#b0c4de', 'linen' => '#faf0e6', 'mediumblue' => '#0000cd', 'mediumpurple' => '#9370db', 'mediumslateblue' => '#7b68ee',
            'mediumturquoise' => '#48d1cc', 'mistyrose' => '#ffe4e1', 'navajowhite' => '#ffdead', 'oldlace' => '#fdf5e6', 'olivedrab' => '#6b8e23', 'orangered' => '#ff4500',
            'palegoldenrod' => '#eee8aa', 'paleturquoise' => '#afeeee', 'papayawhip' => '#ffefd5', 'peru' => '#cd853f', 'plum' => '#dda0dd', 'rosybrown' => '#bc8f8f',
            'saddlebrown' => '#8b4513', 'sandybrown' => '#f4a460', 'seashell' => '#fff5ee', 'slateblue' => '#6a5acd', 'slategrey' => '#708090', 'snow' => '#fffafa',
            'tomato' => '#ff6347', 'violet' => '#ee82ee', 'wheat' => '#f5deb3', 'whitesmoke' => '#f5f5f5', 'yellowgreen' => '#9acd32');

        $this->ColorFlag = false;
        $this->extgstates = array();

        $this->mb_enc = 'windows-1252';
        $this->directionality = 'ltr';
        $this->defaultAlign = 'L';
        $this->defaultTableAlign = 'L';

        $this->fixedPosBlockSave = array();
        $this->extraFontSubsets = 0;

        $this->SHYpatterns = array();
        $this->loadedSHYdictionary = false;
        $this->SHYdictionary = array();
        $this->SHYdictionaryWords = array();
        $this->blockContext = 1;
        $this->floatDivs = array();
        $this->DisplayPreferences = '';

        $this->patterns = array();        // Tiling patterns used for backgrounds
        $this->pageBackgrounds = array();
        $this->writingHTMLheader = false;    // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
        $this->writingHTMLfooter = false;    // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
        $this->gradients = array();

        $this->kwt_Reference = array();
        $this->kwt_BMoutlines = array();
        $this->kwt_toc = array();

        $this->tbrot_Reference = array();
        $this->tbrot_BMoutlines = array();
        $this->tbrot_toc = array();

        $this->col_Reference = array();
        $this->col_BMoutlines = array();
        $this->col_toc = array();
        $this->graphs = array();

        $this->pgsIns = array();
        $this->PDFAXwarnings = array();
        $this->inlineDisplayOff = false;
        $this->kerning = false;
        $this->lSpacingCSS = '';
        $this->wSpacingCSS = '';
        $this->fixedlSpacing = false;
        $this->minwSpacing = 0;


        $this->baselineC = 0.35;    // Baseline for text
        // mPDF 5.7.3  inline text-decoration parameters
        $this->baselineSup = 0.5;    // Sets default change in baseline for <sup> text bas factor of preceeding fontsize
        $this->baselineSub = -0.2;    // Sets default change in baseline for <sub> text bas factor of preceeding fontsize
        $this->baselineS = 0.3;        // Sets default height for <strike> text as factor of fontsize

        $this->noImageFile = str_replace("\\", "/", dirname(__FILE__)) . '/includes/no_image.jpg';
        $this->subPos = 0;
        $this->forceExactLineheight = false;
        $this->listOcc = 0;
        $this->normalLineheight = 1.3;
        // These are intended as configuration variables, and should be set in config.php - which will override these values;
        // set here as failsafe as will cause an error if not defined
        $this->incrementFPR1 = 10;
        $this->incrementFPR2 = 10;
        $this->incrementFPR3 = 10;
        $this->incrementFPR4 = 10;

        $this->fullImageHeight = false;
        $this->floatbuffer = array();
        $this->floatmargins = array();
        $this->autoFontGroups = 0;
        $this->formobjects = array(); // array of Form Objects for WMF
        $this->InlineProperties = array();
        $this->InlineAnnots = array();
        $this->ktAnnots = array();
        $this->tbrot_Annots = array();
        $this->kwt_Annots = array();
        $this->columnAnnots = array();
        $this->pageDim = array();
        $this->breakpoints = array();    // used in columnbuffer
        $this->tableLevel = 0;
        $this->tbctr = array();    // counter for nested tables at each level
        $this->page_box = array();
        $this->show_marks = '';    // crop or cross marks
        $this->kwt = false;
        $this->kwt_height = 0;
        $this->kwt_y0 = 0;
        $this->kwt_x0 = 0;
        $this->kwt_buffer = array();
        $this->kwt_Links = array();
        $this->kwt_moved = false;
        $this->kwt_saved = false;
        $this->PageNumSubstitutions = array();
        $this->base_table_properties = array();
        $this->borderstyles = array('inset', 'groove', 'outset', 'ridge', 'dotted', 'dashed', 'solid', 'double');
        $this->tbrot_align = 'C';
        $this->pageheaders = array();
        $this->pagefooters = array();

        $this->pageHTMLheaders = array();
        $this->pageHTMLfooters = array();
        $this->HTMLheaderPageLinks = array();
        $this->HTMLheaderPageAnnots = array();

        $this->ktForms = array();
        $this->HTMLheaderPageForms = array();
        $this->columnForms = array();
        $this->tbrotForms = array();
        $this->useRC128encryption = false;
        $this->uniqid = '';

        $this->bufferoutput = false;
        $this->encrypted = false;            //whether document is protected
        $this->BMoutlines = array();
        $this->ColActive = 0;                //Flag indicating that columns are on (the index is being processed)
        $this->Reference = array();        //Array containing the references
        $this->CurrCol = 0;                //Current column number
        $this->ColL = array(0);            // Array of Left pos of columns - absolute - needs Margin correction for Odd-Even
        $this->ColR = array(0);            // Array of Right pos of columns - absolute pos - needs Margin correction for Odd-Even
        $this->ChangeColumn = 0;
        $this->columnbuffer = array();
        $this->ColDetails = array();        // Keeps track of some column details
        $this->columnLinks = array();        // Cross references PageLinks
        $this->substitute = array();        // Array of substitution strings e.g. <ttz>112</ttz>
        $this->entsearch = array();        // Array of HTML entities (>ASCII 127) to substitute
        $this->entsubstitute = array();    // Array of substitution decimal unicode for the Hi entities
        $this->lastoptionaltag = '';
        $this->charset_in = '';
        $this->blk = array();
        $this->blklvl = 0;
        $this->tts = false;
        $this->ttz = false;
        $this->tta = false;
        $this->ispre = false;

        $this->checkSIP = false;
        $this->checkSMP = false;
        $this->checkCJK = false;
        $this->tableCJK = false;

        $this->headerDetails = array();
        $this->footerDetails = array();
        $this->page_break_after_avoid = false;
        $this->margin_bottom_collapse = false;
        $this->tablethead = 0;
        $this->tabletfoot = 0;
        $this->table_border_attr_set = 0;
        $this->table_border_css_set = 0;
        $this->shrin_k = 1.0;
        $this->shrink_this_table_to_fit = 0;
        $this->MarginCorrection = 0;

        $this->tabletheadjustfinished = false;
        $this->usingCoreFont = false;
        $this->charspacing = 0;

        $this->autoPageBreak = true;

        require(_MPDF_PATH . 'config.php');    // config data

        $this->_setPageSize($format, $orientation);
        $this->DefOrientation = $orientation;

        $this->margin_header = $mgh;
        $this->margin_footer = $mgf;

        $bmargin = $mgb;

        $this->DeflMargin = $mgl;
        $this->DefrMargin = $mgr;

        $this->orig_tMargin = $mgt;
        $this->orig_bMargin = $bmargin;
        $this->orig_lMargin = $this->DeflMargin;
        $this->orig_rMargin = $this->DefrMargin;
        $this->orig_hMargin = $this->margin_header;
        $this->orig_fMargin = $this->margin_footer;

        if ($this->setAutoTopMargin == 'pad') {
            $mgt += $this->margin_header;
        }
        if ($this->setAutoBottomMargin == 'pad') {
            $mgb += $this->margin_footer;
        }
        $this->SetMargins($this->DeflMargin, $this->DefrMargin, $mgt);    // sets l r t margin
        //Automatic page break
        $this->SetAutoPageBreak($this->autoPageBreak, $bmargin);    // sets $this->bMargin & PageBreakTrigger

        $this->pgwidth = $this->w - $this->lMargin - $this->rMargin;

        //Interior cell margin (1 mm) ? not used
        $this->cMarginL = 1;
        $this->cMarginR = 1;
        //Line width (0.2 mm)
        $this->LineWidth = .567 / _MPDFK;

        //To make the function Footer() work - replaces {nb} with page number
        $this->AliasNbPages();
        $this->AliasNbPageGroups();

        $this->aliasNbPgHex = '{nbHEXmarker}';
        $this->aliasNbPgGpHex = '{nbpgHEXmarker}';

        //Enable all tags as default
        $this->DisableTags();
        //Full width display mode
        $this->SetDisplayMode(100);    // fullwidth?		'fullpage'
        //Compression
        $this->SetCompression(true);
        //Set default display preferences
        $this->SetDisplayPreferences('');

        // Font data
        require(_MPDF_PATH . 'config_fonts.php');
        // Available fonts
        $this->available_unifonts = array();
        foreach ($this->fontdata AS $f => $fs) {
            if (isset($fs['R']) && $fs['R']) {
                $this->available_unifonts[] = $f;
            }
            if (isset($fs['B']) && $fs['B']) {
                $this->available_unifonts[] = $f . 'B';
            }
            if (isset($fs['I']) && $fs['I']) {
                $this->available_unifonts[] = $f . 'I';
            }
            if (isset($fs['BI']) && $fs['BI']) {
                $this->available_unifonts[] = $f . 'BI';
            }
        }

        $this->default_available_fonts = $this->available_unifonts;

        $optcore = false;
        $onlyCoreFonts = false;
        if (preg_match('/([\-+])aCJK/i', $mode, $m)) {
            $mode = preg_replace('/([\-+])aCJK/i', '', $mode);
            if ($m[1] == '+') {
                $this->useAdobeCJK = true;
            } else {
                $this->useAdobeCJK = false;
            }
        }

        if (strlen($mode) == 1) {
            if ($mode == 's') {
                $this->percentSubset = 100;
                $mode = '';
            } else if ($mode == 'c') {
                $onlyCoreFonts = true;
                $mode = '';
            }
        } else if (substr($mode, -2) == '-s') {
            $this->percentSubset = 100;
            $mode = substr($mode, 0, strlen($mode) - 2);
        } else if (substr($mode, -2) == '-c') {
            $onlyCoreFonts = true;
            $mode = substr($mode, 0, strlen($mode) - 2);
        } else if (substr($mode, -2) == '-x') {
            $optcore = true;
            $mode = substr($mode, 0, strlen($mode) - 2);
        }

        // Autodetect if mode is a language_country string (en-GB or en_GB or en)
        if ((strlen($mode) == 5 && $mode != 'UTF-8') || strlen($mode) == 2) {
            list ($coreSuitable, $mpdf_pdf_unifonts) = GetLangOpts($mode, $this->useAdobeCJK);
            if ($coreSuitable && $optcore) {
                $onlyCoreFonts = true;
            }
            if ($mpdf_pdf_unifonts) {
                $this->RestrictUnicodeFonts($mpdf_pdf_unifonts);
                $this->default_available_fonts = $mpdf_pdf_unifonts;
            }
            $this->currentLang = $mode;
            $this->default_lang = $mode;
        }

        $this->onlyCoreFonts = $onlyCoreFonts;

        if ($this->onlyCoreFonts) {
            $this->setMBencoding('windows-1252');    // sets $this->mb_enc
        } else {
            $this->setMBencoding('UTF-8');    // sets $this->mb_enc
        }
        @mb_regex_encoding('UTF-8');    // required only for mb_ereg... and mb_split functions


        // Adobe CJK fonts
        $this->available_CJK_fonts = array('gb', 'big5', 'sjis', 'uhc', 'gbB', 'big5B', 'sjisB', 'uhcB', 'gbI', 'big5I', 'sjisI', 'uhcI',
            'gbBI', 'big5BI', 'sjisBI', 'uhcBI');


        //Standard fonts
        $this->CoreFonts = array('ccourier' => 'Courier', 'ccourierB' => 'Courier-Bold', 'ccourierI' => 'Courier-Oblique', 'ccourierBI' => 'Courier-BoldOblique',
            'chelvetica' => 'Helvetica', 'chelveticaB' => 'Helvetica-Bold', 'chelveticaI' => 'Helvetica-Oblique', 'chelveticaBI' => 'Helvetica-BoldOblique',
            'ctimes' => 'Times-Roman', 'ctimesB' => 'Times-Bold', 'ctimesI' => 'Times-Italic', 'ctimesBI' => 'Times-BoldItalic',
            'csymbol' => 'Symbol', 'czapfdingbats' => 'ZapfDingbats');
        $this->fontlist = array("ctimes", "ccourier", "chelvetica", "csymbol", "czapfdingbats");

        // Substitutions
        $this->setHiEntitySubstitutions();

        if ($this->onlyCoreFonts) {
            $this->useSubstitutions = true;
            $this->SetSubstitutions();
        } else {
            $this->useSubstitutions = false;
        }

        /*-- HTML-CSS --*/

        if (!class_exists('cssmgr', false)) {
            include(_MPDF_PATH . 'classes/cssmgr.php');
        }
        $this->cssmgr = new cssmgr($this);
        if (file_exists(_MPDF_PATH . 'mpdf.css')) {
            $css = file_get_contents(_MPDF_PATH . 'mpdf.css');
            $css2 = $this->cssmgr->ReadDefaultCSS($css);
            $this->defaultCSS = $this->cssmgr->array_merge_recursive_unique($this->defaultCSS, $css2);
        }
        /*-- END HTML-CSS --*/

        if ($default_font == '') {
            if ($this->onlyCoreFonts) {
                if (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']), $this->mono_fonts)) {
                    $default_font = 'ccourier';
                } else if (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']), $this->sans_fonts)) {
                    $default_font = 'chelvetica';
                } else {
                    $default_font = 'ctimes';
                }
            } else {
                $default_font = $this->defaultCSS['BODY']['FONT-FAMILY'];
            }
        }
        if (!$default_font_size) {
            $mmsize = $this->ConvertSize($this->defaultCSS['BODY']['FONT-SIZE']);
            $default_font_size = $mmsize * (_MPDFK);
        }

        if ($default_font) {
            $this->SetDefaultFont($default_font);
        }
        if ($default_font_size) {
            $this->SetDefaultFontSize($default_font_size);
        }

        $this->SetLineHeight();    // lineheight is in mm

        $this->SetFColor($this->ConvertColor(255));
        $this->HREF = '';
        $this->oldy = -1;
        $this->B = 0;
        $this->U = false;
        $this->S = false;
        $this->I = 0;

        $this->listlvl = 0;
        $this->listnum = 0;
        $this->listtype = '';
        $this->listoccur = array();
        $this->listlist = array();
        $this->listitem = array();

        $this->tdbegin = false;
        $this->table = array();
        $this->cell = array();
        $this->col = -1;
        $this->row = -1;
        $this->cellBorderBuffer = array();

        $this->divbegin = false;
        $this->divalign = '';
        $this->divwidth = 0;
        $this->divheight = 0;
        $this->spanbgcolor = false;
        $this->divrevert = false;
        $this->spanborder = false;
        $this->spanborddet = array();

        $this->blockjustfinished = false;
        $this->listjustfinished = false;
        $this->ignorefollowingspaces = true; //in order to eliminate exceeding left-side spaces
        $this->toupper = false;
        $this->tolower = false;
        $this->capitalize = false;
        $this->dash_on = false;
        $this->dotted_on = false;
        $this->SUP = false;
        $this->SUB = false;
        $this->strike = false;
        $this->textshadow = '';

        $this->currentfontfamily = '';
        $this->currentfontsize = '';
        $this->currentfontstyle = '';
        $this->colorarray = array();
        $this->spanbgcolorarray = array();
        $this->textbuffer = array();
        $this->internallink = array();
        $this->basepath = "";

        $this->SetBasePath('');

        $this->textparam = array();

        $this->specialcontent = '';
        $this->selectoption = array();

        /*-- IMPORTS --*/

        $this->tpls = array();
        $this->tpl = 0;
        $this->tplprefix = "/TPL";
        $this->res = array();
        if ($this->enableImports) {
            $this->SetImportUse();
        }
        /*-- END IMPORTS --*/

        if ($this->progressBar) {
            $this->StartProgressBarOutput($this->progressBar);
        }    // *PROGRESS-BAR*
    }

    function _dochecks()
    {
        //Check for locale-related bug
        if (1.1 == 1)
            $this->Error('Don\'t alter the locale before including mPDF');
        //Check for decimal separator
        if (sprintf('%.1f', 1.0) != '1.0')
            setlocale(LC_NUMERIC, 'C');
        // mPDF 5.4.11
        $mqr = ini_get("magic_quotes_runtime");
        if ($mqr) {
            $this->Error('mPDF requires magic_quotes_runtime to be turned off e.g. by using ini_set("magic_quotes_runtime", 0);');
        }
    }

    function Error($msg)
    {
        //Fatal error
        header('Content-Type: text/html; charset=utf-8');
        die('<B>mPDF error: </B>' . $msg);
    }


    /*-- PROGRESS-BAR --*/

    function SetTColor($col, $return = false)
    {
        $out = $this->SetColor($col, 'Text');
        if ($return) {
            return $out;
        }
        if ($out == '') {
            return '';
        }
        $this->TextColor = $out;
        $this->ColorFlag = ($this->FillColor != $out);
    }

    function SetColor($col, $type = '')
    {
        $out = '';
        if ($col{0} == 3 || $col{0} == 5) {    // RGB / RGBa
            $out = sprintf('%.3F %.3F %.3F rg', ord($col{1}) / 255, ord($col{2}) / 255, ord($col{3}) / 255);
        } else if ($col{0} == 1) {    // GRAYSCALE
            $out = sprintf('%.3F g', ord($col{1}) / 255);
        } else if ($col{0} == 2) {    // SPOT COLOR
            $out = sprintf('/CS%d cs %.3F scn', ord($col{1}), ord($col{2}) / 100);
        } else if ($col{0} == 4 || $col{0} == 6) {    // CMYK / CMYKa
            $out = sprintf('%.3F %.3F %.3F %.3F k', ord($col{1}) / 100, ord($col{2}) / 100, ord($col{3}) / 100, ord($col{4}) / 100);
        }
        if ($type == 'Draw') {
            $out = strtoupper($out);
        }    // e.g. rg => RG
        else if ($type == 'CodeOnly') {
            $out = preg_replace('/\s(rg|g|k)/', '', $out);
        }
        return $out;
    }

    /*-- END PROGRESS-BAR --*/

    function ConvertColor($color = "#000000")
    {
        $color = trim(strtolower($color));
        $c = false;
        if ($color == 'transparent') {
            return false;
        } else if ($color == 'inherit') {
            return false;
        } else if (isset($this->SVGcolors[$color])) $color = $this->SVGcolors[$color];

        if (preg_match('/^[\d]+$/', $color)) {
            $c = (array(1, $color));
        }    // i.e. integer only
        else if ($color[0] == '#') { //case of #nnnnnn or #nnn
            $cor = preg_replace('/\s+.*/', '', $color);    // in case of Background: #CCC url() x-repeat etc.
            if (strlen($cor) == 4) { // Turn #RGB into #RRGGBB
                $cor = "#" . $cor[1] . $cor[1] . $cor[2] . $cor[2] . $cor[3] . $cor[3];
            }
            $r = hexdec(substr($cor, 1, 2));
            $g = hexdec(substr($cor, 3, 2));
            $b = hexdec(substr($cor, 5, 2));
            $c = array(3, $r, $g, $b);
        } else if (preg_match('/(rgba|rgb|device-cmyka|cmyka|device-cmyk|cmyk|hsla|hsl|spot)\((.*?)\)/', $color, $m)) {    // mPDF 5.6.05
            $type = $m[1];
            $cores = explode(",", $m[2]);
            $ncores = count($cores);
            if (stristr($cores[0], '%')) {
                $cores[0] += 0;
                if ($type == 'rgb' || $type == 'rgba') {
                    $cores[0] = intval($cores[0] * 255 / 100);
                }
            }
            if ($ncores > 1 && stristr($cores[1], '%')) {
                $cores[1] += 0;
                if ($type == 'rgb' || $type == 'rgba') {
                    $cores[1] = intval($cores[1] * 255 / 100);
                }
                if ($type == 'hsl' || $type == 'hsla') {
                    $cores[1] = $cores[1] / 100;
                }
            }
            if ($ncores > 2 && stristr($cores[2], '%')) {
                $cores[2] += 0;
                if ($type == 'rgb' || $type == 'rgba') {
                    $cores[2] = intval($cores[2] * 255 / 100);
                }
                if ($type == 'hsl' || $type == 'hsla') {
                    $cores[2] = $cores[2] / 100;
                }
            }
            if ($ncores > 3 && stristr($cores[3], '%')) {
                $cores[3] += 0;
            }

            if ($type == 'rgb') {
                $c = array(3, $cores[0], $cores[1], $cores[2]);
            } else if ($type == 'rgba') {
                $c = array(5, $cores[0], $cores[1], $cores[2], $cores[3] * 100);
            } else if ($type == 'cmyk' || $type == 'device-cmyk') {
                $c = array(4, $cores[0], $cores[1], $cores[2], $cores[3]);
            }    // mPDF 5.6.05
            else if ($type == 'cmyka' || $type == 'device-cmyka') {
                $c = array(6, $cores[0], $cores[1], $cores[2], $cores[3], $cores[4] * 100);
            }    // mPDF 5.6.05
            else if ($type == 'hsl' || $type == 'hsla') {
                $conv = $this->hsl2rgb($cores[0] / 360, $cores[1], $cores[2]);
                if ($type == 'hsl') {
                    $c = array(3, $conv[0], $conv[1], $conv[2]);
                } else if ($type == 'hsla') {
                    $c = array(5, $conv[0], $conv[1], $conv[2], $cores[3] * 100);
                }
            } else if ($type == 'spot') {
                $name = strtoupper(trim($cores[0]));
                // mPDF 5.6.59
                if (!isset($this->spotColors[$name])) {
                    if (isset($cores[5])) {
                        $this->AddSpotColor($cores[0], $cores[2], $cores[3], $cores[4], $cores[5]);
                    } else {
                        $this->Error('Undefined spot color: ' . $name);
                    }
                }
                $c = array(2, $this->spotColors[$name]['i'], $cores[1]);
            }
        }


        // $this->restrictColorSpace
        // 1 - allow GRAYSCALE only [convert CMYK/RGB->gray]
        // 2 - allow RGB / SPOT COLOR / Grayscale [convert CMYK->RGB]
        // 3 - allow CMYK / SPOT COLOR / Grayscale [convert RGB->CMYK]
        if ($this->PDFA || $this->PDFX || $this->restrictColorSpace) {
            if ($c[0] == 1) {    // GRAYSCALE
            } else if ($c[0] == 2) {    // SPOT COLOR
                if (!isset($this->spotColorIDs[$c[1]])) {
                    die('Error: Spot colour has not been defined - ' . $this->spotColorIDs[$c[1]]);
                }
                if ($this->PDFA) {
                    if ($this->PDFA && !$this->PDFAauto) {
                        $this->PDFAXwarnings[] = "Spot color specified '" . $this->spotColorIDs[$c[1]] . "' (converted to process color)";
                    }
                    if ($this->restrictColorSpace != 3) {
                        $sp = $this->spotColors[$this->spotColorIDs[$c[1]]];
                        $c = $this->cmyk2rgb(array(4, $sp['c'], $sp['m'], $sp['y'], $sp['k']));
                    }
                } else if ($this->restrictColorSpace == 1) {
                    $sp = $this->spotColors[$this->spotColorIDs[$c[1]]];
                    $c = $this->cmyk2gray(array(4, $sp['c'], $sp['m'], $sp['y'], $sp['k']));
                }
            } else if ($c[0] == 3) {    // RGB
                if ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3)) {
                    if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                        $this->PDFAXwarnings[] = "RGB color specified '" . $color . "' (converted to CMYK)";
                    }
                    $c = $this->rgb2cmyk($c);
                } else if ($this->restrictColorSpace == 1) {
                    $c = $this->rgb2gray($c);
                } else if ($this->restrictColorSpace == 3) {
                    $c = $this->rgb2cmyk($c);
                }
            } else if ($c[0] == 4) {    // CMYK
                if ($this->PDFA && $this->restrictColorSpace != 3) {
                    if ($this->PDFA && !$this->PDFAauto) {
                        $this->PDFAXwarnings[] = "CMYK color specified '" . $color . "' (converted to RGB)";
                    }
                    $c = $this->cmyk2rgb($c);
                } else if ($this->restrictColorSpace == 1) {
                    $c = $this->cmyk2gray($c);
                } else if ($this->restrictColorSpace == 2) {
                    $c = $this->cmyk2rgb($c);
                }
            } else if ($c[0] == 5) {    // RGBa
                if ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3)) {
                    if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                        $this->PDFAXwarnings[] = "RGB color with transparency specified '" . $color . "' (converted to CMYK without transparency)";
                    }
                    $c = $this->rgb2cmyk($c);
                    $c = array(4, $c[1], $c[2], $c[3], $c[4]);
                } else if ($this->PDFA && $this->restrictColorSpace != 3) {
                    if (!$this->PDFAauto) {
                        $this->PDFAXwarnings[] = "RGB color with transparency specified '" . $color . "' (converted to RGB without transparency)";
                    }
                    $c = $this->rgb2cmyk($c);
                    $c = array(4, $c[1], $c[2], $c[3], $c[4]);
                } else if ($this->restrictColorSpace == 1) {
                    $c = $this->rgb2gray($c);
                } else if ($this->restrictColorSpace == 3) {
                    $c = $this->rgb2cmyk($c);
                }
            } else if ($c[0] == 6) {    // CMYKa
                if ($this->PDFA && $this->restrictColorSpace != 3) {
                    if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                        $this->PDFAXwarnings[] = "CMYK color with transparency specified '" . $color . "' (converted to RGB without transparency)";
                    }
                    $c = $this->cmyk2rgb($c);
                    $c = array(3, $c[1], $c[2], $c[3]);
                } else if ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3)) {
                    if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                        $this->PDFAXwarnings[] = "CMYK color with transparency specified '" . $color . "' (converted to CMYK without transparency)";
                    }
                    $c = $this->cmyk2rgb($c);
                    $c = array(3, $c[1], $c[2], $c[3]);
                } else if ($this->restrictColorSpace == 1) {
                    $c = $this->cmyk2gray($c);
                } else if ($this->restrictColorSpace == 2) {
                    $c = $this->cmyk2rgb($c);
                }
            }
        }
        if (is_array($c)) {
            $c = array_pad($c, 6, 0);
            $cstr = pack("a1ccccc", $c[0], ($c[1] & 0xFF), ($c[2] & 0xFF), ($c[3] & 0xFF), ($c[4] & 0xFF), ($c[5] & 0xFF));
        }
        return $cstr;
    }

    function hsl2rgb($h2, $s2, $l2)
    {
        // Input is HSL value of complementary colour, held in $h2, $s, $l as fractions of 1
        // Output is RGB in normal 255 255 255 format, held in $r, $g, $b
        // Hue is converted using function hue_2_rgb, shown at the end of this code
        if ($s2 == 0) {
            $r = $l2 * 255;
            $g = $l2 * 255;
            $b = $l2 * 255;
        } else {
            if ($l2 < 0.5) {
                $var_2 = $l2 * (1 + $s2);
            } else {
                $var_2 = ($l2 + $s2) - ($s2 * $l2);
            }
            $var_1 = 2 * $l2 - $var_2;
            $r = round(255 * $this->hue_2_rgb($var_1, $var_2, $h2 + (1 / 3)));
            $g = round(255 * $this->hue_2_rgb($var_1, $var_2, $h2));
            $b = round(255 * $this->hue_2_rgb($var_1, $var_2, $h2 - (1 / 3)));
        }
        return array($r, $g, $b);
    }

    function hue_2_rgb($v1, $v2, $vh)
    {
        // Function to convert hue to RGB, called from above
        if ($vh < 0) {
            $vh += 1;
        };
        if ($vh > 1) {
            $vh -= 1;
        };
        if ((6 * $vh) < 1) {
            return ($v1 + ($v2 - $v1) * 6 * $vh);
        };
        if ((2 * $vh) < 1) {
            return ($v2);
        };
        if ((3 * $vh) < 2) {
            return ($v1 + ($v2 - $v1) * ((2 / 3 - $vh) * 6));
        };
        return ($v1);
    }

    function AddSpotColor($name, $c, $m, $y, $k)
    {
        $name = strtoupper(trim($name));
        if (!isset($this->spotColors[$name])) {
            $i = count($this->spotColors) + 1;
            $this->spotColors[$name] = array('i' => $i, 'c' => $c, 'm' => $m, 'y' => $y, 'k' => $k);
            $this->spotColorIDs[$i] = $name;
        }
    }

    function cmyk2rgb($c)
    {
        $rgb = array();
        $colors = 255 - ($c[4] * 2.55);
        $rgb[0] = intval($colors * (255 - ($c[1] * 2.55)) / 255);
        $rgb[1] = intval($colors * (255 - ($c[2] * 2.55)) / 255);
        $rgb[2] = intval($colors * (255 - ($c[3] * 2.55)) / 255);
        if ($c[0] == 6) {
            return array(5, $rgb[0], $rgb[1], $rgb[2], $c[5]);
        } else {
            return array(3, $rgb[0], $rgb[1], $rgb[2]);
        }
    }

    function cmyk2gray($c)
    {
        $rgb = $this->cmyk2rgb($c);
        return $this->rgb2gray($rgb);
    }

    function rgb2gray($c)
    {
        if (isset($c[4])) {
            return array(1, (($c[1] * .21) + ($c[2] * .71) + ($c[3] * .07)), ord(1), $c[4]);
        } else {
            return array(1, (($c[1] * .21) + ($c[2] * .71) + ($c[3] * .07)));
        }
    }

    function rgb2cmyk($c)
    {
        $cyan = 1 - ($c[1] / 255);
        $magenta = 1 - ($c[2] / 255);
        $yellow = 1 - ($c[3] / 255);
        $min = min($cyan, $magenta, $yellow);

        if ($min == 1) {
            if ($c[0] == 5) {
                return array(6, 100, 100, 100, 100, $c[4]);
            } else {
                return array(4, 100, 100, 100, 100);
            }
            // For K-Black
            //if ($c[0]==5) { return array (6,0,0,0,100, $c[4]); }
            //else { return array (4,0,0,0,100); }
        }
        $K = $min;
        $black = 1 - $K;
        if ($c[0] == 5) {
            return array(6, ($cyan - $K) * 100 / $black, ($magenta - $K) * 100 / $black, ($yellow - $K) * 100 / $black, $K * 100, $c[4]);
        } else {
            return array(4, ($cyan - $K) * 100 / $black, ($magenta - $K) * 100 / $black, ($yellow - $K) * 100 / $black, $K * 100);
        }
    }

    function SetDColor($col, $return = false)
    {
        $out = $this->SetColor($col, 'Draw');
        if ($return) {
            return $out;
        }
        if ($out == '') {
            return '';
        }
        $this->DrawColor = $out;
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['DrawColor']) && $this->pageoutput[$this->page]['DrawColor'] != $this->DrawColor) || !isset($this->pageoutput[$this->page]['DrawColor']) || $this->keep_block_together)) {
            $this->_out($this->DrawColor);
        }
        $this->pageoutput[$this->page]['DrawColor'] = $this->DrawColor;
    }

    function _out($s, $ln = true)
    {
        if ($this->state == 2) {
            if ($this->bufferoutput) {
                $this->headerbuffer .= $s . "\n";
            } /*-- COLUMNS --*/
            else if (($this->ColActive) && !$this->processingHeader && !$this->processingFooter) {
                // Captures everything in buffer for columns; Almost everything is sent from fn. Cell() except:
                // Images sent from Image() or
                // later sent as _out($textto) in printbuffer
                // Line()
                if (preg_match('/q \d+\.\d\d+ 0 0 (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ cm \/(I|FO)\d+ Do Q/', $s, $m)) {    // Image data
                    $h = ($m[1] / _MPDFK);
                    // Update/overwrite the lowest bottom of printing y value for a column
                    $this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $h;
                } /*-- TABLES --*/
                else if (preg_match('/\d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ ([\-]{0,1}\d+\.\d\d+) re/', $s, $m) && $this->tableLevel > 0) { // Rect in table
                    $h = ($m[1] / _MPDFK);
                    // Update/overwrite the lowest bottom of printing y value for a column
                    $this->ColDetails[$this->CurrCol]['bottom_margin'] = max($this->ColDetails[$this->CurrCol]['bottom_margin'], ($this->y + $h));
                } /*-- END TABLES --*/
                else {    // Td Text Set in Cell()
                    if (isset($this->ColDetails[$this->CurrCol]['bottom_margin'])) {
                        $h = $this->ColDetails[$this->CurrCol]['bottom_margin'] - $this->y;
                    } else {
                        $h = 0;
                    }
                }
                if ($h < 0) {
                    $h = -$h;
                }
                $this->columnbuffer[] = array(
                    's' => $s,                            // Text string to output
                    'col' => $this->CurrCol,                // Column when printed
                    'x' => $this->x,                        // x when printed
                    'y' => $this->y,                        // this->y when printed (after column break)
                    'h' => $h                            // actual y at bottom when printed = y+h
                );
            }
            /*-- END COLUMNS --*/
            /*-- TABLES --*/
            else if ($this->table_rotate && !$this->processingHeader && !$this->processingFooter) {
                // Captures eveything in buffer for rotated tables;
                $this->tablebuffer .= $s . "\n";
            } /*-- END TABLES --*/
            else if ($this->kwt && !$this->processingHeader && !$this->processingFooter) {
                // Captures eveything in buffer for keep-with-table (h1-6);
                $this->kwt_buffer[] = array(
                    's' => $s,                            // Text string to output
                    'x' => $this->x,                        // x when printed
                    'y' => $this->y,                        // y when printed
                );
            } else if (($this->keep_block_together) && !$this->processingHeader && !$this->processingFooter) {
                if (!isset($this->ktBlock[$this->page]['bottom_margin'])) {
                    $this->ktBlock[$this->page]['bottom_margin'] = $this->y;
                }

                // Captures eveything in buffer;
                if (preg_match('/q \d+\.\d\d+ 0 0 (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ cm \/(I|FO)\d+ Do Q/', $s, $m)) {    // Image data
                    $h = ($m[1] / _MPDFK);
                    // Update/overwrite the lowest bottom of printing y value for Keep together block
                    $this->ktBlock[$this->page]['bottom_margin'] = $this->y + $h;
                } else {    // Td Text Set in Cell()
                    if (isset($this->ktBlock[$this->page]['bottom_margin'])) {
                        $h = $this->ktBlock[$this->page]['bottom_margin'] - $this->y;
                    } else {
                        $h = 0;
                    }
                }
                if ($h < 0) {
                    $h = -$h;
                }
                $this->divbuffer[] = array(
                    'page' => $this->page,
                    's' => $s,                            // Text string to output
                    'x' => $this->x,                        // x when printed
                    'y' => $this->y,                        // y when printed (after column break)
                    'h' => $h                            // actual y at bottom when printed = y+h
                );
            } else {
                $this->pages[$this->page] .= $s . ($ln == true ? "\n" : '');
            }

        } else {
            $this->buffer .= $s . ($ln == true ? "\n" : '');
        }
    }

    function SetFColor($col, $return = false)
    {
        $out = $this->SetColor($col, 'Fill');
        if ($return) {
            return $out;
        }
        if ($out == '') {
            return '';
        }
        $this->FillColor = $out;
        $this->ColorFlag = ($out != $this->TextColor);
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor']) || $this->keep_block_together)) {
            $this->_out($this->FillColor);
        }
        $this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
    }

    function _setPageSize($format, &$orientation)
    {
        //Page format
        if (is_string($format)) {
            if ($format == '') {
                $format = 'A4';
            }
            $pfo = 'P';
            if (preg_match('/([0-9a-zA-Z]*)-L/i', $format, $m)) {    // e.g. A4-L = A4 landscape
                $format = $m[1];
                $pfo = 'L';
            }
            $format = $this->_getPageFormat($format);
            if (!$format) {
                $this->Error('Unknown page format: ' . $format);
            } else {
                $orientation = $pfo;
            }

            $this->fwPt = $format[0];
            $this->fhPt = $format[1];
        } else {
            if (!$format[0] || !$format[1]) {
                $this->Error('Invalid page format: ' . $format[0] . ' ' . $format[1]);
            }
            $this->fwPt = $format[0] * _MPDFK;
            $this->fhPt = $format[1] * _MPDFK;
        }
        $this->fw = $this->fwPt / _MPDFK;
        $this->fh = $this->fhPt / _MPDFK;
        //Page orientation
        $orientation = strtolower($orientation);
        if ($orientation == 'p' or $orientation == 'portrait') {
            $orientation = 'P';
            $this->wPt = $this->fwPt;
            $this->hPt = $this->fhPt;
        } elseif ($orientation == 'l' or $orientation == 'landscape') {
            $orientation = 'L';
            $this->wPt = $this->fhPt;
            $this->hPt = $this->fwPt;
        } else $this->Error('Incorrect orientation: ' . $orientation);
        $this->CurOrientation = $orientation;

        $this->w = $this->wPt / _MPDFK;
        $this->h = $this->hPt / _MPDFK;
    }

    function _getPageFormat($format)
    {
        switch (strtoupper($format)) {
            case '4A0':
                {
                    $format = array(4767.87, 6740.79);
                    break;
                }
            case '2A0':
                {
                    $format = array(3370.39, 4767.87);
                    break;
                }
            case 'A0':
                {
                    $format = array(2383.94, 3370.39);
                    break;
                }
            case 'A1':
                {
                    $format = array(1683.78, 2383.94);
                    break;
                }
            case 'A2':
                {
                    $format = array(1190.55, 1683.78);
                    break;
                }
            case 'A3':
                {
                    $format = array(841.89, 1190.55);
                    break;
                }
            case 'A4':
                {
                    $format = array(595.28, 841.89);
                    break;
                }    // mPDF 5.7.4
            case 'A5':
                {
                    $format = array(419.53, 595.28);
                    break;
                }
            case 'A6':
                {
                    $format = array(297.64, 419.53);
                    break;
                }
            case 'A7':
                {
                    $format = array(209.76, 297.64);
                    break;
                }
            case 'A8':
                {
                    $format = array(147.40, 209.76);
                    break;
                }
            case 'A9':
                {
                    $format = array(104.88, 147.40);
                    break;
                }
            case 'A10':
                {
                    $format = array(73.70, 104.88);
                    break;
                }
            case 'B0':
                {
                    $format = array(2834.65, 4008.19);
                    break;
                }
            case 'B1':
                {
                    $format = array(2004.09, 2834.65);
                    break;
                }
            case 'B2':
                {
                    $format = array(1417.32, 2004.09);
                    break;
                }
            case 'B3':
                {
                    $format = array(1000.63, 1417.32);
                    break;
                }
            case 'B4':
                {
                    $format = array(708.66, 1000.63);
                    break;
                }
            case 'B5':
                {
                    $format = array(498.90, 708.66);
                    break;
                }
            case 'B6':
                {
                    $format = array(354.33, 498.90);
                    break;
                }
            case 'B7':
                {
                    $format = array(249.45, 354.33);
                    break;
                }
            case 'B8':
                {
                    $format = array(175.75, 249.45);
                    break;
                }
            case 'B9':
                {
                    $format = array(124.72, 175.75);
                    break;
                }
            case 'B10':
                {
                    $format = array(87.87, 124.72);
                    break;
                }
            case 'C0':
                {
                    $format = array(2599.37, 3676.54);
                    break;
                }
            case 'C1':
                {
                    $format = array(1836.85, 2599.37);
                    break;
                }
            case 'C2':
                {
                    $format = array(1298.27, 1836.85);
                    break;
                }
            case 'C3':
                {
                    $format = array(918.43, 1298.27);
                    break;
                }
            case 'C4':
                {
                    $format = array(649.13, 918.43);
                    break;
                }
            case 'C5':
                {
                    $format = array(459.21, 649.13);
                    break;
                }
            case 'C6':
                {
                    $format = array(323.15, 459.21);
                    break;
                }
            case 'C7':
                {
                    $format = array(229.61, 323.15);
                    break;
                }
            case 'C8':
                {
                    $format = array(161.57, 229.61);
                    break;
                }
            case 'C9':
                {
                    $format = array(113.39, 161.57);
                    break;
                }
            case 'C10':
                {
                    $format = array(79.37, 113.39);
                    break;
                }
            case 'RA0':
                {
                    $format = array(2437.80, 3458.27);
                    break;
                }
            case 'RA1':
                {
                    $format = array(1729.13, 2437.80);
                    break;
                }
            case 'RA2':
                {
                    $format = array(1218.90, 1729.13);
                    break;
                }
            case 'RA3':
                {
                    $format = array(864.57, 1218.90);
                    break;
                }
            case 'RA4':
                {
                    $format = array(609.45, 864.57);
                    break;
                }
            case 'SRA0':
                {
                    $format = array(2551.18, 3628.35);
                    break;
                }
            case 'SRA1':
                {
                    $format = array(1814.17, 2551.18);
                    break;
                }
            case 'SRA2':
                {
                    $format = array(1275.59, 1814.17);
                    break;
                }
            case 'SRA3':
                {
                    $format = array(907.09, 1275.59);
                    break;
                }
            case 'SRA4':
                {
                    $format = array(637.80, 907.09);
                    break;
                }
            case 'LETTER':
                {
                    $format = array(612.00, 792.00);
                    break;
                }
            case 'LEGAL':
                {
                    $format = array(612.00, 1008.00);
                    break;
                }
            case 'LEDGER':
                {
                    $format = array(279.00, 432.00);
                    break;
                }
            case 'TABLOID':
                {
                    $format = array(279.00, 432.00);
                    break;
                }
            case 'EXECUTIVE':
                {
                    $format = array(521.86, 756.00);
                    break;
                }
            case 'FOLIO':
                {
                    $format = array(612.00, 936.00);
                    break;
                }
            case 'B':
                {
                    $format = array(362.83, 561.26);
                    break;
                }        //	'B' format paperback size 128x198mm
            case 'A':
                {
                    $format = array(314.65, 504.57);
                    break;
                }        //	'A' format paperback size 111x178mm
            case 'DEMY':
                {
                    $format = array(382.68, 612.28);
                    break;
                }        //	'Demy' format paperback size 135x216mm
            case 'ROYAL':
                {
                    $format = array(433.70, 663.30);
                    break;
                }    //	'Royal' format paperback size 153x234mm
            default:
                {
                    $format = array(595.28, 841.89);
                    break;
                }    // mPDF 5.7.4
        }
        return $format;
    }

    function SetMargins($left, $right, $top)
    {
        //Set left, top and right margins
        $this->lMargin = $left;
        $this->rMargin = $right;
        $this->tMargin = $top;
    }

    function SetAutoPageBreak($auto, $margin = 0)
    {
        //Set auto page break mode and triggering margin
        $this->autoPageBreak = $auto;
        $this->bMargin = $margin;
        $this->PageBreakTrigger = $this->h - $margin;
    }

    function AliasNbPages($alias = '{nb}')
    {
        //Define an alias for total number of pages
        $this->aliasNbPg = $alias;
    }

    function AliasNbPageGroups($alias = '{nbpg}')
    {
        //Define an alias for total number of pages in a group
        $this->aliasNbPgGp = $alias;
    }

    function DisableTags($str = '')
    {
        if ($str == '') //enable all tags
        {
            //Insert new supported tags in the long string below.
            $this->enabledtags = "<span><s><strike><del><bdo><big><small><ins><cite><acronym><font><sup><sub><b><u><i><a><strong><em><code><samp><tt><kbd><var><q><table><thead><tfoot><tbody><tr><th><td><ol><ul><li><dl><dt><dd><form><input><select><textarea><option><div><p><h1><h2><h3><h4><h5><h6><pre><center><blockquote><address><hr><img><br><indexentry><indexinsert><bookmark><watermarktext><watermarkimage><tts><ttz><tta><column_break><columnbreak><newcolumn><newpage><page_break><pagebreak><formfeed><columns><toc><tocentry><tocpagebreak><pageheader><pagefooter><setpageheader><setpagefooter><sethtmlpageheader><sethtmlpagefooter><annotation><template><jpgraph><barcode><dottab><caption><textcircle><fieldset><legend><article><aside><figure><figcaption><footer><header><hgroup><nav><section><mark><main><details><summary><meter><progress><time>";    // mPDF 5.7.3
        } else {
            $str = explode(",", $str);
            foreach ($str as $v) $this->enabledtags = str_replace(trim($v), '', $this->enabledtags);
        }
    }

    function SetDisplayMode($zoom, $layout = 'continuous')
    {
        //Set display mode in viewer
        if ($zoom == 'fullpage' or $zoom == 'fullwidth' or $zoom == 'real' or $zoom == 'default' or !is_string($zoom))
            $this->ZoomMode = $zoom;
        else
            $this->Error('Incorrect zoom display mode: ' . $zoom);
        if ($layout == 'single' or $layout == 'continuous' or $layout == 'two' or $layout == 'twoleft' or $layout == 'tworight' or $layout == 'default')
            $this->LayoutMode = $layout;
        else
            $this->Error('Incorrect layout display mode: ' . $layout);
    }

    function SetCompression($compress)
    {
        //Set page compression
        if (function_exists('gzcompress')) $this->compress = $compress;
        else $this->compress = false;
    }

    function SetDisplayPreferences($preferences)
    {
        // String containing any or none of /HideMenubar/HideToolbar/HideWindowUI/DisplayDocTitle/CenterWindow/FitWindow
        $this->DisplayPreferences .= $preferences;
    }

    function RestrictUnicodeFonts($res)
    {
        // $res = array of (Unicode) fonts to restrict to: e.g. norasi|norasiB - language specific
        if (count($res)) {    // Leave full list of available fonts if passed blank array
            $this->available_unifonts = $res;
        } else {
            $this->available_unifonts = $this->default_available_fonts;
        }
        if (count($this->available_unifonts) == 0) {
            $this->available_unifonts[] = $this->default_available_fonts[0];
        }
        $this->available_unifonts = array_values($this->available_unifonts);
    }

    function setMBencoding($enc)
    {
        if ($this->mb_enc != $enc) {
            $this->mb_enc = $enc;
            mb_internal_encoding($this->mb_enc);
        }
    }

    function setHiEntitySubstitutions()
    {
        $entarr = array(
            'nbsp' => '160', 'iexcl' => '161', 'cent' => '162', 'pound' => '163', 'curren' => '164', 'yen' => '165', 'brvbar' => '166', 'sect' => '167',
            'uml' => '168', 'copy' => '169', 'ordf' => '170', 'laquo' => '171', 'not' => '172', 'shy' => '173', 'reg' => '174', 'macr' => '175',
            'deg' => '176', 'plusmn' => '177', 'sup2' => '178', 'sup3' => '179', 'acute' => '180', 'micro' => '181', 'para' => '182', 'middot' => '183',
            'cedil' => '184', 'sup1' => '185', 'ordm' => '186', 'raquo' => '187', 'frac14' => '188', 'frac12' => '189', 'frac34' => '190',
            'iquest' => '191', 'Agrave' => '192', 'Aacute' => '193', 'Acirc' => '194', 'Atilde' => '195', 'Auml' => '196', 'Aring' => '197',
            'AElig' => '198', 'Ccedil' => '199', 'Egrave' => '200', 'Eacute' => '201', 'Ecirc' => '202', 'Euml' => '203', 'Igrave' => '204',
            'Iacute' => '205', 'Icirc' => '206', 'Iuml' => '207', 'ETH' => '208', 'Ntilde' => '209', 'Ograve' => '210', 'Oacute' => '211',
            'Ocirc' => '212', 'Otilde' => '213', 'Ouml' => '214', 'times' => '215', 'Oslash' => '216', 'Ugrave' => '217', 'Uacute' => '218',
            'Ucirc' => '219', 'Uuml' => '220', 'Yacute' => '221', 'THORN' => '222', 'szlig' => '223', 'agrave' => '224', 'aacute' => '225',
            'acirc' => '226', 'atilde' => '227', 'auml' => '228', 'aring' => '229', 'aelig' => '230', 'ccedil' => '231', 'egrave' => '232',
            'eacute' => '233', 'ecirc' => '234', 'euml' => '235', 'igrave' => '236', 'iacute' => '237', 'icirc' => '238', 'iuml' => '239',
            'eth' => '240', 'ntilde' => '241', 'ograve' => '242', 'oacute' => '243', 'ocirc' => '244', 'otilde' => '245', 'ouml' => '246',
            'divide' => '247', 'oslash' => '248', 'ugrave' => '249', 'uacute' => '250', 'ucirc' => '251', 'uuml' => '252', 'yacute' => '253',
            'thorn' => '254', 'yuml' => '255', 'OElig' => '338', 'oelig' => '339', 'Scaron' => '352', 'scaron' => '353', 'Yuml' => '376',
            'fnof' => '402', 'circ' => '710', 'tilde' => '732', 'Alpha' => '913', 'Beta' => '914', 'Gamma' => '915', 'Delta' => '916',
            'Epsilon' => '917', 'Zeta' => '918', 'Eta' => '919', 'Theta' => '920', 'Iota' => '921', 'Kappa' => '922', 'Lambda' => '923',
            'Mu' => '924', 'Nu' => '925', 'Xi' => '926', 'Omicron' => '927', 'Pi' => '928', 'Rho' => '929', 'Sigma' => '931', 'Tau' => '932',
            'Upsilon' => '933', 'Phi' => '934', 'Chi' => '935', 'Psi' => '936', 'Omega' => '937', 'alpha' => '945', 'beta' => '946', 'gamma' => '947',
            'delta' => '948', 'epsilon' => '949', 'zeta' => '950', 'eta' => '951', 'theta' => '952', 'iota' => '953', 'kappa' => '954',
            'lambda' => '955', 'mu' => '956', 'nu' => '957', 'xi' => '958', 'omicron' => '959', 'pi' => '960', 'rho' => '961', 'sigmaf' => '962',
            'sigma' => '963', 'tau' => '964', 'upsilon' => '965', 'phi' => '966', 'chi' => '967', 'psi' => '968', 'omega' => '969',
            'thetasym' => '977', 'upsih' => '978', 'piv' => '982', 'ensp' => '8194', 'emsp' => '8195', 'thinsp' => '8201', 'zwnj' => '8204',
            'zwj' => '8205', 'lrm' => '8206', 'rlm' => '8207', 'ndash' => '8211', 'mdash' => '8212', 'lsquo' => '8216', 'rsquo' => '8217',
            'sbquo' => '8218', 'ldquo' => '8220', 'rdquo' => '8221', 'bdquo' => '8222', 'dagger' => '8224', 'Dagger' => '8225', 'bull' => '8226',
            'hellip' => '8230', 'permil' => '8240', 'prime' => '8242', 'Prime' => '8243', 'lsaquo' => '8249', 'rsaquo' => '8250', 'oline' => '8254',
            'frasl' => '8260', 'euro' => '8364', 'image' => '8465', 'weierp' => '8472', 'real' => '8476', 'trade' => '8482', 'alefsym' => '8501',
            'larr' => '8592', 'uarr' => '8593', 'rarr' => '8594', 'darr' => '8595', 'harr' => '8596', 'crarr' => '8629', 'lArr' => '8656',
            'uArr' => '8657', 'rArr' => '8658', 'dArr' => '8659', 'hArr' => '8660', 'forall' => '8704', 'part' => '8706', 'exist' => '8707',
            'empty' => '8709', 'nabla' => '8711', 'isin' => '8712', 'notin' => '8713', 'ni' => '8715', 'prod' => '8719', 'sum' => '8721',
            'minus' => '8722', 'lowast' => '8727', 'radic' => '8730', 'prop' => '8733', 'infin' => '8734', 'ang' => '8736', 'and' => '8743',
            'or' => '8744', 'cap' => '8745', 'cup' => '8746', 'int' => '8747', 'there4' => '8756', 'sim' => '8764', 'cong' => '8773',
            'asymp' => '8776', 'ne' => '8800', 'equiv' => '8801', 'le' => '8804', 'ge' => '8805', 'sub' => '8834', 'sup' => '8835', 'nsub' => '8836',
            'sube' => '8838', 'supe' => '8839', 'oplus' => '8853', 'otimes' => '8855', 'perp' => '8869', 'sdot' => '8901', 'lceil' => '8968',
            'rceil' => '8969', 'lfloor' => '8970', 'rfloor' => '8971', 'lang' => '9001', 'rang' => '9002', 'loz' => '9674', 'spades' => '9824',
            'clubs' => '9827', 'hearts' => '9829', 'diams' => '9830',
        );
        foreach ($entarr AS $key => $val) {
            $this->entsearch[] = '&' . $key . ';';
            $this->entsubstitute[] = code2utf($val);
        }
    }

    /*-- BACKGROUNDS --*/

    function SetSubstitutions()
    {
        $subsarray = array();
        @include(_MPDF_PATH . 'includes/subs_win-1252.php');
        $this->substitute = array();
        foreach ($subsarray AS $key => $val) {
            $this->substitute[code2utf($key)] = $val;
        }
    }

    function ConvertSize($size = 5, $maxsize = 0, $fontsize = false, $usefontsize = true)
    {
// usefontsize - setfalse for e.g. margins - will ignore fontsize for % values
// Depends of maxsize value to make % work properly. Usually maxsize == pagewidth
// For text $maxsize = Fontsize
// Setting e.g. margin % will use maxsize (pagewidth) and em will use fontsize
        //Identify size (remember: we are using 'mm' units here)
        $size = trim(strtolower($size));

        if ($size == 'thin') $size = 1 * (25.4 / $this->dpi); //1 pixel width for table borders
        elseif (stristr($size, 'px')) $size *= (25.4 / $this->dpi); //pixels
        elseif (stristr($size, 'cm')) $size *= 10; //centimeters
        elseif (stristr($size, 'mm')) $size += 0; //millimeters
        elseif (stristr($size, 'pt')) $size *= 25.4 / 72; //72 pts/inch
        elseif (stristr($size, 'rem')) {    // mPDF 5.6.12
            $size += 0; //make "0.83rem" become simply "0.83"
            $size *= ($this->default_font_size / _MPDFK);
        } elseif (stristr($size, 'em')) {
            $size += 0; //make "0.83em" become simply "0.83"
            if ($fontsize) {
                $size *= $fontsize;
            } else {
                $size *= $maxsize;
            }
        } elseif (stristr($size, '%')) {
            $size += 0; //make "90%" become simply "90"
            if ($fontsize && $usefontsize) {
                $size *= $fontsize / 100;
            } else {
                $size *= $maxsize / 100;
            }
        } elseif (stristr($size, 'in')) $size *= 25.4; //inches
        elseif (stristr($size, 'pc')) $size *= 38.1 / 9; //PostScript picas
        elseif (stristr($size, 'ex')) {    // Approximates "ex" as half of font height
            $size += 0; //make "3.5ex" become simply "3.5"
            if ($fontsize) {
                $size *= $fontsize / 2;
            } else {
                $size *= $maxsize / 2;
            }
        } elseif ($size == 'medium') $size = 3 * (25.4 / $this->dpi); //3 pixel width for table borders
        elseif ($size == 'thick') $size = 5 * (25.4 / $this->dpi); //5 pixel width for table borders
        elseif ($size == 'xx-small') {
            if ($fontsize) {
                $size *= $fontsize * 0.7;
            } else {
                $size *= $maxsize * 0.7;
            }
        } elseif ($size == 'x-small') {
            if ($fontsize) {
                $size *= $fontsize * 0.77;
            } else {
                $size *= $maxsize * 0.77;
            }
        } elseif ($size == 'small') {
            if ($fontsize) {
                $size *= $fontsize * 0.86;
            } else {
                $size *= $maxsize * 0.86;
            }
        } elseif ($size == 'medium') {
            if ($fontsize) {
                $size *= $fontsize;
            } else {
                $size *= $maxsize;
            }
        } elseif ($size == 'large') {
            if ($fontsize) {
                $size *= $fontsize * 1.2;
            } else {
                $size *= $maxsize * 1.2;
            }
        } elseif ($size == 'x-large') {
            if ($fontsize) {
                $size *= $fontsize * 1.5;
            } else {
                $size *= $maxsize * 1.5;
            }
        } elseif ($size == 'xx-large') {
            if ($fontsize) {
                $size *= $fontsize * 2;
            } else {
                $size *= $maxsize * 2;
            }
        } else $size *= (25.4 / $this->dpi); //nothing == px

        return $size;
    }

    /*-- END BACKGROUNDS --*/

    function SetDefaultFont($font)
    {
        // Disallow embedded fonts to be used as defaults in PDFA
        if ($this->PDFA || $this->PDFX) {
            if (strtolower($font) == 'ctimes') {
                $font = 'serif';
            }
            if (strtolower($font) == 'ccourier') {
                $font = 'monospace';
            }
            if (strtolower($font) == 'chelvetica') {
                $font = 'sans-serif';
            }
        }
        $font = $this->SetFont($font);    // returns substituted font if necessary
        $this->default_font = $font;
        $this->original_default_font = $font;
        if (!$this->watermark_font) {
            $this->watermark_font = $font;
        }    // *WATERMARK*
        $this->defaultCSS['BODY']['FONT-FAMILY'] = $font;
        $this->cssmgr->CSS['BODY']['FONT-FAMILY'] = $font;
    }

    function SetFont($family, $style = '', $size = 0, $write = true, $forcewrite = false)
    {
        $family = strtolower($family);
        if (!$this->onlyCoreFonts) {
            if ($family == 'sans' || $family == 'sans-serif') {
                $family = $this->sans_fonts[0];
            }
            if ($family == 'serif') {
                $family = $this->serif_fonts[0];
            }
            if ($family == 'mono' || $family == 'monospace') {
                $family = $this->mono_fonts[0];
            }
        }
        if (isset($this->fonttrans[$family]) && $this->fonttrans[$family]) {
            $family = $this->fonttrans[$family];
        }
        if ($family == '') {
            if ($this->FontFamily) {
                $family = $this->FontFamily;
            } else if ($this->default_font) {
                $family = $this->default_font;
            } else {
                $this->Error("No font or default font set!");
            }
        }
        $this->ReqFontStyle = $style;    // required or requested style - used later for artificial bold/italic

        if (($family == 'csymbol') || ($family == 'czapfdingbats') || ($family == 'ctimes') || ($family == 'ccourier') || ($family == 'chelvetica')) {
            if ($this->PDFA || $this->PDFX) {
                if ($family == 'csymbol' || $family == 'czapfdingbats') {
                    $this->Error("Symbol and Zapfdingbats cannot be embedded in mPDF (required for PDFA1-b or PDFX/1-a).");
                }
                if ($family == 'ctimes' || $family == 'ccourier' || $family == 'chelvetica') {
                    if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                        $this->PDFAXwarnings[] = "Core Adobe font " . ucfirst($family) . " cannot be embedded in mPDF, which is required for PDFA1-b or PDFX/1-a. (Embedded font will be substituted.)";
                    }
                    if ($family == 'chelvetica') {
                        $family = 'sans';
                    }
                    if ($family == 'ctimes') {
                        $family = 'serif';
                    }
                    if ($family == 'ccourier') {
                        $family = 'mono';
                    }
                }
                $this->usingCoreFont = false;
            } else {
                $this->usingCoreFont = true;
            }
            if ($family == 'csymbol' || $family == 'czapfdingbats') {
                $style = '';
            }
        } else {
            $this->usingCoreFont = false;
        }

        $this->U = false;
        $this->S = false;
        if ($style) {
            $style = strtoupper($style);
            if (strpos($style, 'U') !== false) {
                $this->U = true;
                $style = str_replace('U', '', $style);
            }
            if (strpos($style, 'S') !== false) {
                $this->S = true;
                // Small Caps
                if (empty($this->upperCase)) {
                    @include(_MPDF_PATH . 'includes/upperCase.php');
                }
                $style = str_replace('S', '', $style);
            }
            if ($style == 'IB') $style = 'BI';
        }
        if ($size == 0) $size = $this->FontSizePt;

        $fontkey = $family . $style;

        $stylekey = $style;
        if (!$stylekey) {
            $stylekey = "R";
        }

        if (!$this->onlyCoreFonts && !$this->usingCoreFont) {
            if (!isset($this->fonts[$fontkey]) || count($this->default_available_fonts) != count($this->available_unifonts)) { // not already added
                /*-- CJK-FONTS --*/
                // CJK fonts
                if (in_array($fontkey, $this->available_CJK_fonts)) {
                    if (!isset($this->fonts[$fontkey])) {    // already added
                        if (empty($this->Big5_widths)) {
                            require(_MPDF_PATH . 'includes/CJKdata.php');
                        }
                        $this->AddCJKFont($family);    // don't need to add style
                    }
                } // Test to see if requested font/style is available - or substitute
                else
                    /*-- END CJK-FONTS --*/
                    if (!in_array($fontkey, $this->available_unifonts)) {
                        // If font[nostyle] exists - set it
                        if (in_array($family, $this->available_unifonts)) {
                            $style = '';
                        } // Else if only one font available - set it (assumes if only one font available it will not have a style)
                        else if (count($this->available_unifonts) == 1) {
                            $family = $this->available_unifonts[0];
                            $style = '';
                        } else {
                            $found = 0;
                            // else substitute font of similar type
                            if (in_array($family, $this->sans_fonts)) {
                                $i = array_intersect($this->sans_fonts, $this->available_unifonts);
                                if (count($i)) {
                                    $i = array_values($i);
                                    // with requested style if possible
                                    if (!in_array(($i[0] . $style), $this->available_unifonts)) {
                                        $style = '';
                                    }
                                    $family = $i[0];
                                    $found = 1;
                                }
                            } else if (in_array($family, $this->serif_fonts)) {
                                $i = array_intersect($this->serif_fonts, $this->available_unifonts);
                                if (count($i)) {
                                    $i = array_values($i);
                                    // with requested style if possible
                                    if (!in_array(($i[0] . $style), $this->available_unifonts)) {
                                        $style = '';
                                    }
                                    $family = $i[0];
                                    $found = 1;
                                }
                            } else if (in_array($family, $this->mono_fonts)) {
                                $i = array_intersect($this->mono_fonts, $this->available_unifonts);
                                if (count($i)) {
                                    $i = array_values($i);
                                    // with requested style if possible
                                    if (!in_array(($i[0] . $style), $this->available_unifonts)) {
                                        $style = '';
                                    }
                                    $family = $i[0];
                                    $found = 1;
                                }
                            }

                            if (!$found) {
                                // set first available font
                                $fs = $this->available_unifonts[0];
                                preg_match('/^([a-z_0-9\-]+)([BI]{0,2})$/', $fs, $fas);    // Allow "-"
                                // with requested style if possible
                                $ws = $fas[1] . $style;
                                if (in_array($ws, $this->available_unifonts)) {
                                    $family = $fas[1]; // leave $style as is
                                } else if (in_array($fas[1], $this->available_unifonts)) {
                                    // or without style
                                    $family = $fas[1];
                                    $style = '';
                                } else {
                                    // or with the style specified
                                    $family = $fas[1];
                                    $style = $fas[2];
                                }
                            }
                        }
                        $fontkey = $family . $style;
                    }
            }
            // try to add font (if not already added)
            $this->AddFont($family, $style);

            //Test if font is already selected
            if ($this->FontFamily == $family && $this->FontFamily == $this->currentfontfamily && $this->FontStyle == $style && $this->FontStyle == $this->currentfontstyle && $this->FontSizePt == $size && $this->FontSizePt == $this->currentfontsize && !$forcewrite) {
                return $family;
            }

            $fontkey = $family . $style;

            //Select it
            $this->FontFamily = $family;
            $this->FontStyle = $style;
            $this->FontSizePt = $size;
            $this->FontSize = $size / _MPDFK;
            $this->CurrentFont = &$this->fonts[$fontkey];
            if ($write) {
                $fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
                if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) {
                    $this->_out($fontout);
                }
                $this->pageoutput[$this->page]['Font'] = $fontout;
            }


            // Added - currentfont (lowercase) used in HTML2PDF
            $this->currentfontfamily = $family;
            $this->currentfontsize = $size;
            $this->currentfontstyle = $style . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');
            $this->setMBencoding('UTF-8');
        } else {    // if using core fonts


            if ($this->PDFA || $this->PDFX) {
                $this->Error('Core Adobe fonts cannot be embedded in mPDF (required for PDFA1-b or PDFX/1-a) - cannot use option to use core fonts.');
            }
            $this->setMBencoding('windows-1252');

            //Test if font is already selected
            if (($this->FontFamily == $family) AND ($this->FontStyle == $style) AND ($this->FontSizePt == $size) && !$forcewrite) {
                return $family;
            }

            if (!isset($this->CoreFonts[$fontkey])) {
                if (in_array($family, $this->serif_fonts)) {
                    $family = 'ctimes';
                } else if (in_array($family, $this->mono_fonts)) {
                    $family = 'ccourier';
                } else {
                    $family = 'chelvetica';
                }
                $this->usingCoreFont = true;
                $fontkey = $family . $style;
            }

            if (!isset($this->fonts[$fontkey])) {
                // STANDARD CORE FONTS
                if (isset($this->CoreFonts[$fontkey])) {
                    //Load metric file
                    $file = $family;
                    if ($family == 'ctimes' || $family == 'chelvetica' || $family == 'ccourier') {
                        $file .= strtolower($style);
                    }
                    $file .= '.php';
                    include(_MPDF_PATH . 'font/' . $file);
                    if (!isset($cw)) {
                        $this->Error('Could not include font metric file');
                    }
                    $i = count($this->fonts) + $this->extraFontSubsets + 1;
                    $this->fonts[$fontkey] = array('i' => $i, 'type' => 'core', 'name' => $this->CoreFonts[$fontkey], 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw);
                    if ($this->useKerning) {
                        $this->fonts[$fontkey]['kerninfo'] = $kerninfo;
                    }
                } else {
                    die('mPDF error - Font not defined');
                }
            }
            //Test if font is already selected
            if (($this->FontFamily == $family) AND ($this->FontStyle == $style) AND ($this->FontSizePt == $size) && !$forcewrite) {
                return $family;
            }
            //Select it
            $this->FontFamily = $family;
            $this->FontStyle = $style;
            $this->FontSizePt = $size;
            $this->FontSize = $size / _MPDFK;
            $this->CurrentFont =& $this->fonts[$fontkey];
            if ($write) {
                $fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
                if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) {
                    $this->_out($fontout);
                }
                $this->pageoutput[$this->page]['Font'] = $fontout;
            }
            // Added - currentfont (lowercase) used in HTML2PDF
            $this->currentfontfamily = $family;
            $this->currentfontsize = $size;
            $this->currentfontstyle = $style . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');

        }

        return $family;
    }

    function AddCJKFont($family)
    {

        if ($this->PDFA || $this->PDFX) {
            $this->Error("Adobe CJK fonts cannot be embedded in mPDF (required for PDFA1-b and PDFX/1-a).");
        }
        if ($family == 'big5') {
            $this->AddBig5Font();
        } else if ($family == 'gb') {
            $this->AddGBFont();
        } else if ($family == 'sjis') {
            $this->AddSJISFont();
        } else if ($family == 'uhc') {
            $this->AddUHCFont();
        }
    }

// mPDF 5.6.01 - LAYERS

    function AddBig5Font()
    {
        //Add Big5 font with proportional Latin
        $family = 'big5';
        $name = 'MSungStd-Light-Acro';
        $cw = $this->Big5_widths;
        $CMap = 'UniCNS-UTF16-H';
        $registry = array('ordering' => 'CNS1', 'supplement' => 4);
        $desc = array(
            'Ascent' => 880,
            'Descent' => -120,
            'CapHeight' => 880,
            'Flags' => 6,
            'FontBBox' => '[-160 -249 1015 1071]',
            'ItalicAngle' => 0,
            'StemV' => 93,
        );
        $this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
    }

    function AddCIDFont($family, $style, $name, &$cw, $CMap, $registry, $desc)
    {
        $fontkey = strtolower($family) . strtoupper($style);
        if (isset($this->fonts[$fontkey]))
            $this->Error("Font already added: $family $style");
        $i = count($this->fonts) + $this->extraFontSubsets + 1;
        $name = str_replace(' ', '', $name);
        if ($family == 'sjis') {
            $up = -120;
        } else {
            $up = -130;
        }
        // ? 'up' and 'ut' do not seem to be referenced anywhere
        $this->fonts[$fontkey] = array('i' => $i, 'type' => 'Type0', 'name' => $name, 'up' => $up, 'ut' => 40, 'cw' => $cw, 'CMap' => $CMap, 'registry' => $registry, 'MissingWidth' => 1000, 'desc' => $desc);
    }


// Depracated - can use AddPage for all

    function AddGBFont()
    {
        //Add GB font with proportional Latin
        $family = 'gb';
        $name = 'STSongStd-Light-Acro';
        $cw = $this->GB_widths;
        $CMap = 'UniGB-UTF16-H';
        $registry = array('ordering' => 'GB1', 'supplement' => 4);
        $desc = array(
            'Ascent' => 752,
            'Descent' => -271,
            'CapHeight' => 737,
            'Flags' => 6,
            'FontBBox' => '[-25 -254 1000 880]',
            'ItalicAngle' => 0,
            'StemV' => 58,
            'Style' => '<< /Panose <000000000400000000000000> >>',
        );
        $this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
    }

    function AddSJISFont()
    {
        //Add SJIS font with proportional Latin
        $family = 'sjis';
        $name = 'KozMinPro-Regular-Acro';
        $cw = $this->SJIS_widths;
        $CMap = 'UniJIS-UTF16-H';
        $registry = array('ordering' => 'Japan1', 'supplement' => 5);
        $desc = array(
            'Ascent' => 880,
            'Descent' => -120,
            'CapHeight' => 740,
            'Flags' => 6,
            'FontBBox' => '[-195 -272 1110 1075]',
            'ItalicAngle' => 0,
            'StemV' => 86,
            'XHeight' => 502,
        );
        $this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
    }

    function AddUHCFont()
    {
        //Add UHC font with proportional Latin
        $family = 'uhc';
        $name = 'HYSMyeongJoStd-Medium-Acro';
        $cw = $this->UHC_widths;
        $CMap = 'UniKS-UTF16-H';
        $registry = array('ordering' => 'Korea1', 'supplement' => 2);
        $desc = array(
            'Ascent' => 880,
            'Descent' => -120,
            'CapHeight' => 720,
            'Flags' => 6,
            'FontBBox' => '[-28 -148 1001 880]',
            'ItalicAngle' => 0,
            'StemV' => 60,
            'Style' => '<< /Panose <000000000600000000000000> >>',
        );
        $this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
        $this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
    }

    function AddFont($family, $style = '')
    {
        if (empty($family)) {
            return;
        }
        $family = strtolower($family);
        $style = strtoupper($style);
        $style = str_replace('U', '', $style);
        if ($style == 'IB') $style = 'BI';
        $fontkey = $family . $style;
        // check if the font has been already added
        if (isset($this->fonts[$fontkey])) {
            return;
        }

        /*-- CJK-FONTS --*/
        if (in_array($family, $this->available_CJK_fonts)) {
            if (empty($this->Big5_widths)) {
                require(_MPDF_PATH . 'includes/CJKdata.php');
            }
            $this->AddCJKFont($family);    // don't need to add style
            return;
        }
        /*-- END CJK-FONTS --*/

        if ($this->usingCoreFont) {
            die("mPDF Error - problem with Font management");
        }

        $stylekey = $style;
        if (!$style) {
            $stylekey = 'R';
        }

        if (!isset($this->fontdata[$family][$stylekey]) || !$this->fontdata[$family][$stylekey]) {
            die('mPDF Error - Font is not supported - ' . $family . ' ' . $style);
        }

        $name = '';
        $originalsize = 0;
        $sip = false;
        $smp = false;
        $unAGlyphs = false;    // mPDF 5.4.05
        $haskerninfo = false;
        $BMPselected = false;
        @include(_MPDF_TTFONTDATAPATH . $fontkey . '.mtx.php');

        $ttffile = '';
        if (defined('_MPDF_SYSTEM_TTFONTS')) {
            $ttffile = _MPDF_SYSTEM_TTFONTS . $this->fontdata[$family][$stylekey];
            if (!file_exists($ttffile)) {
                $ttffile = '';
            }
        }
        if (!$ttffile) {
            $ttffile = _MPDF_TTFONTPATH . $this->fontdata[$family][$stylekey];
            if (!file_exists($ttffile)) {
                die("mPDF Error - cannot find TTF TrueType font file - " . $ttffile);
            }
        }
        $ttfstat = stat($ttffile);

        if (isset($this->fontdata[$family]['TTCfontID'][$stylekey])) {
            $TTCfontID = $this->fontdata[$family]['TTCfontID'][$stylekey];
        } else {
            $TTCfontID = 0;
        }


        $BMPonly = false;
        if (in_array($family, $this->BMPonly)) {
            $BMPonly = true;
        }
        $regenerate = false;
        if ($BMPonly && !$BMPselected) {
            $regenerate = true;
        } else if (!$BMPonly && $BMPselected) {
            $regenerate = true;
        }
        if ($this->useKerning && !$haskerninfo) {
            $regenerate = true;
        }
        // mPDF 5.4.05
        if (isset($this->fontdata[$family]['unAGlyphs']) && $this->fontdata[$family]['unAGlyphs'] && !$unAGlyphs) {
            $regenerate = true;
            $unAGlyphs = true;
        } else if ((!isset($this->fontdata[$family]['unAGlyphs']) || !$this->fontdata[$family]['unAGlyphs']) && $unAGlyphs) {
            $regenerate = true;
            $unAGlyphs = false;
        }
        if (!isset($name) || $originalsize != $ttfstat['size'] || $regenerate) {
            if (!class_exists('TTFontFile', false)) {
                include(_MPDF_PATH . 'classes/ttfontsuni.php');
            }
            $ttf = new TTFontFile();
            $ttf->getMetrics($ttffile, $TTCfontID, $this->debugfonts, $BMPonly, $this->useKerning, $unAGlyphs);    // mPDF 5.4.05
            $cw = $ttf->charWidths;
            $kerninfo = $ttf->kerninfo;
            $haskerninfo = true;
            $name = preg_replace('/[ ()]/', '', $ttf->fullName);
            $sip = $ttf->sipset;
            $smp = $ttf->smpset;

            $desc = array('Ascent' => round($ttf->ascent),
                'Descent' => round($ttf->descent),
                'CapHeight' => round($ttf->capHeight),
                'Flags' => $ttf->flags,
                'FontBBox' => '[' . round($ttf->bbox[0]) . " " . round($ttf->bbox[1]) . " " . round($ttf->bbox[2]) . " " . round($ttf->bbox[3]) . ']',
                'ItalicAngle' => $ttf->italicAngle,
                'StemV' => round($ttf->stemV),
                'MissingWidth' => round($ttf->defaultWidth));
            $panose = '';
            // mPDF 5.5.19
            if (count($ttf->panose)) {
                $panoseArray = array_merge(array($ttf->sFamilyClass, $ttf->sFamilySubClass), $ttf->panose);
                foreach ($panoseArray as $value)
                    $panose .= ' ' . dechex($value);
            }
            $up = round($ttf->underlinePosition);
            $ut = round($ttf->underlineThickness);
            $originalsize = $ttfstat['size'] + 0;
            $type = 'TTF';
            //Generate metrics .php file
            $s = '<?php' . "\n";
            $s .= '$name=\'' . $name . "';\n";
            $s .= '$type=\'' . $type . "';\n";
            $s .= '$desc=' . var_export($desc, true) . ";\n";
            $s .= '$up=' . $up . ";\n";
            $s .= '$ut=' . $ut . ";\n";
            $s .= '$ttffile=\'' . $ttffile . "';\n";
            $s .= '$TTCfontID=\'' . $TTCfontID . "';\n";
            $s .= '$originalsize=' . $originalsize . ";\n";
            if ($sip) $s .= '$sip=true;' . "\n";
            else $s .= '$sip=false;' . "\n";
            if ($smp) $s .= '$smp=true;' . "\n";
            else $s .= '$smp=false;' . "\n";
            if ($BMPonly) $s .= '$BMPselected=true;' . "\n";
            else $s .= '$BMPselected=false;' . "\n";
            $s .= '$fontkey=\'' . $fontkey . "';\n";
            $s .= '$panose=\'' . $panose . "';\n";
            if ($this->useKerning) {
                $s .= '$kerninfo=' . var_export($kerninfo, true) . ";\n";
                $s .= '$haskerninfo=true;' . "\n";
            } else $s .= '$haskerninfo=false;' . "\n";
            // mPDF 5.4.05
            if ($this->fontdata[$family]['unAGlyphs']) {
                $s .= '$unAGlyphs=true;' . "\n";
            } else $s .= '$unAGlyphs=false;' . "\n";
            $s .= "?>";
            if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
                $fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.mtx.php', "w");
                fwrite($fh, $s, strlen($s));
                fclose($fh);
                $fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.cw.dat', "wb");
                fwrite($fh, $cw, strlen($cw));
                fclose($fh);
                @unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cgm');
                @unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.z');
                @unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cw127.php');
                @unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cw');
            } else if ($this->debugfonts) {
                $this->Error('Cannot write to the font caching directory - ' . _MPDF_TTFONTDATAPATH);
            }
            unset($ttf);
        } else {
            $cw = @file_get_contents(_MPDF_TTFONTDATAPATH . $fontkey . '.cw.dat');
        }

        if (isset($this->fontdata[$family]['indic']) && $this->fontdata[$family]['indic']) {
            $indic = true;
        } else {
            $indic = false;
        }
        if (isset($this->fontdata[$family]['sip-ext']) && $this->fontdata[$family]['sip-ext']) {
            $sipext = $this->fontdata[$family]['sip-ext'];
        } else {
            $sipext = '';
        }


        $i = count($this->fonts) + $this->extraFontSubsets + 1;
        if ($sip || $smp) {
            $this->fonts[$fontkey] = array('i' => $i, 'type' => $type, 'name' => $name, 'desc' => $desc, 'panose' => $panose, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'ttffile' => $ttffile, 'fontkey' => $fontkey, 'subsets' => array(0 => range(0, 127)), 'subsetfontids' => array($i), 'used' => false, 'indic' => $indic, 'sip' => $sip, 'sipext' => $sipext, 'smp' => $smp, 'TTCfontID' => $TTCfontID, 'unAGlyphs' => false);    // mPDF 5.4.05
        } else {
            $ss = array();
            for ($s = 32; $s < 128; $s++) {
                $ss[$s] = $s;
            }
            $this->fonts[$fontkey] = array('i' => $i, 'type' => $type, 'name' => $name, 'desc' => $desc, 'panose' => $panose, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'ttffile' => $ttffile, 'fontkey' => $fontkey, 'subset' => $ss, 'used' => false, 'indic' => $indic, 'sip' => $sip, 'sipext' => $sipext, 'smp' => $smp, 'TTCfontID' => $TTCfontID, 'unAGlyphs' => $unAGlyphs);    // mPDF 5.4.05
        }
        if ($this->useKerning && $haskerninfo) {
            $this->fonts[$fontkey]['kerninfo'] = $kerninfo;
        }
        $this->FontFiles[$fontkey] = array('length1' => $originalsize, 'type' => "TTF", 'ttffile' => $ttffile, 'sip' => $sip, 'smp' => $smp);
        unset($cw);
    }

    function SetDefaultFontSize($fontsize)
    {
        $this->default_font_size = $fontsize;
        $this->original_default_font_size = $fontsize;
        $this->SetFontSize($fontsize);
        $this->defaultCSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
        $this->cssmgr->CSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
    }

    function SetFontSize($size, $write = true)
    {
        //Set font size in points
        if ($this->FontSizePt == $size) return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / _MPDFK;
        $this->currentfontsize = $size;
        if ($write) {
            $fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
            // Edited mPDF 3.0
            if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']) || $this->keep_block_together)) {
                $this->_out($fontout);
            }
            $this->pageoutput[$this->page]['Font'] = $fontout;
        }
    }

    function SetLineHeight($FontPt = '', $spacing = '')
    {
        if ($this->shrin_k > 1) {
            $k = $this->shrin_k;
        } else {
            $k = 1;
        }
        if ($spacing > 0) {
            if (preg_match('/mm/', $spacing)) {
                $this->lineheight = ($spacing + 0.0) / $k; // convert to number
            } else {
                if ($FontPt) {
                    $this->lineheight = (($FontPt / _MPDFK) * $spacing);
                } else {
                    $this->lineheight = (($this->FontSizePt / _MPDFK) * $spacing);
                }
            }
        } else {
            if ($FontPt) {
                $this->lineheight = (($FontPt / _MPDFK) * $this->normalLineheight);
            } else {
                $this->lineheight = (($this->FontSizePt / _MPDFK) * $this->normalLineheight);
            }
        }
    }

    function SetBasePath($str = '')
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else if (isset($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'];
        } else {
            $host = '';
        }
        if (!$str) {
            if ($_SERVER['SCRIPT_NAME']) {
                $currentPath = dirname($_SERVER['SCRIPT_NAME']);
            } else {
                $currentPath = dirname($_SERVER['PHP_SELF']);
            }
            $currentPath = str_replace("\\", "/", $currentPath);
            if ($currentPath == '/') {
                $currentPath = '';
            }
            if ($host) {
                $currpath = 'http://' . $host . $currentPath . '/';
            } else {
                $currpath = '';
            }
            $this->basepath = $currpath;
            $this->basepathIsLocal = true;
            return;
        }
        $str = preg_replace('/\?.*/', '', $str);
        if (!preg_match('/(http|https|ftp):\/\/.*\//i', $str)) {
            $str .= '/';
        }
        $str .= 'xxx';    // in case $str ends in / e.g. http://www.bbc.co.uk/
        $this->basepath = dirname($str) . "/";    // returns e.g. e.g. http://www.google.com/dir1/dir2/dir3/
        $this->basepath = str_replace("\\", "/", $this->basepath); //If on Windows
        $tr = parse_url($this->basepath);
        if (isset($tr['host']) && ($tr['host'] == $host)) {
            $this->basepathIsLocal = true;
        } else {
            $this->basepathIsLocal = false;
        }
    }

    function SetImportUse()
    {
        $this->enableImports = true;
        ini_set('auto_detect_line_endings', 1);
        require_once(_MPDF_PATH . "mpdfi/pdf_context.php");
        require_once(_MPDF_PATH . "mpdfi/pdf_parser.php");
        require_once(_MPDF_PATH . "mpdfi/fpdi_pdf_parser.php");
    }

    function StartProgressBarOutput($mode = 1)
    {
        // must be relative path, or URI (not a file system path)
        if (!defined('_MPDF_URI')) {
            $this->progressBar = false;
            if ($this->debug) {
                $this->Error("You need to define _MPDF_URI to use the progress bar!");
            } else return false;
        }
        $this->progressBar = $mode;
        if ($this->progbar_altHTML) {
            echo $this->progbar_altHTML;
        } else {
            echo '<html>
	<head>
	<title>mPDF File Progress</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="' . _MPDF_URI . 'progbar.css" />
		</head>
	<body>
	<div class="main">
		<div class="heading">' . $this->progbar_heading . '</div>
		<div class="demo">
	   ';
            if ($this->progressBar == 2) {
                echo '		<table width="100%"><tr><td style="width: 50%;">
			<span class="barheading">Writing HTML code</span> <br/>

			<div class="progressBar">
			<div id="element1"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box1"></span>
			</td><td style="width: 50%;">
			<span class="barheading">Autosizing elements</span> <br/>
			<div class="progressBar">
			<div id="element4"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box4"></span>
			<br/><br/>
			<span class="barheading">Writing Tables</span> <br/>
			<div class="progressBar">
			<div id="element7"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box7"></span>
			</td></tr>
			<tr><td><br /><br /></td><td></td></tr>
			<tr><td style="width: 50%;">
	';
            }
            echo '			<span class="barheading">Writing PDF file</span> <br/>
			<div class="progressBar">
			<div id="element2"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box2"></span>
	   ';
            if ($this->progressBar == 2) {
                echo '
			</td><td style="width: 50%;">
			<span class="barheading">Memory usage</span> <br/>
			<div class="progressBar">
			<div id="element5"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box5">0</span> ' . ini_get("memory_limit") . '<br />
			<br/><br/>
			<span class="barheading">Memory usage (peak)</span> <br/>
			<div class="progressBar">
			<div id="element6"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box6">0</span> ' . ini_get("memory_limit") . '<br />
			</td></tr>
			</table>
	   ';
            }
            echo '			<br/><br/>
		<span id="box3"></span>

		</div>
	   ';
        }
        ob_flush();
        flush();
    }

    function SetLeftMargin($margin)
    {
        //Set left margin
        $this->lMargin = $margin;
        if ($this->page > 0 and $this->x < $margin) $this->x = $margin;
    }

    function SetTopMargin($margin)
    {
        //Set top margin
        $this->tMargin = $margin;
    }

    function SetRightMargin($margin)
    {
        //Set right margin
        $this->rMargin = $margin;
    }

    function SetCreator($creator)
    {
        //Creator of document
        $this->creator = $creator;
    }

    function SetAnchor2Bookmark($x)
    {
        $this->anchor2Bookmark = $x;
    }

    function SetBackground(&$properties, &$maxwidth)
    {
        // mPDF 5.6.10  5.6.11
        if (isset($properties['BACKGROUND-ORIGIN']) && ($properties['BACKGROUND-ORIGIN'] == 'border-box' || $properties['BACKGROUND-ORIGIN'] == 'content-box')) {
            $origin = $properties['BACKGROUND-ORIGIN'];
        } else {
            $origin = 'padding-box';
        }
        // mPDF 5.6.10
        if (isset($properties['BACKGROUND-SIZE'])) {
            if (stristr($properties['BACKGROUND-SIZE'], 'contain')) {
                $bsw = $bsh = 'contain';
            } else if (stristr($properties['BACKGROUND-SIZE'], 'cover')) {
                $bsw = $bsh = 'cover';
            } else {
                $bsw = $bsh = 'auto';
                $sz = preg_split('/\s+/', trim($properties['BACKGROUND-SIZE']));
                if (count($sz) == 2) {
                    $bsw = $sz[0];
                    $bsh = $sz[1];
                } else {
                    $bsw = $sz[0];
                }
                if (!stristr($bsw, '%') && !stristr($bsw, 'auto')) {
                    $bsw = $this->ConvertSize($bsw, $maxwidth, $this->FontSize);
                }
                if (!stristr($bsh, '%') && !stristr($bsh, 'auto')) {
                    $bsh = $this->ConvertSize($bsh, $maxwidth, $this->FontSize);
                }
            }
            $size = array('w' => $bsw, 'h' => $bsh);
        }
        if (preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $properties['BACKGROUND-IMAGE'])) {
            return array('gradient' => $properties['BACKGROUND-IMAGE'], 'origin' => $origin, 'size' => $size);    // mPDF 5.6.10
        } else {
            $file = $properties['BACKGROUND-IMAGE'];
            $sizesarray = $this->Image($file, 0, 0, 0, 0, '', '', false, false, false, false, true);
            if (isset($sizesarray['IMAGE_ID'])) {
                $image_id = $sizesarray['IMAGE_ID'];
                $orig_w = $sizesarray['WIDTH'] * _MPDFK;        // in user units i.e. mm
                $orig_h = $sizesarray['HEIGHT'] * _MPDFK;        // (using $this->img_dpi)
                if (isset($properties['BACKGROUND-IMAGE-RESOLUTION'])) {
                    if (preg_match('/from-image/i', $properties['BACKGROUND-IMAGE-RESOLUTION']) && isset($sizesarray['set-dpi']) && $sizesarray['set-dpi'] > 0) {
                        $orig_w *= $this->img_dpi / $sizesarray['set-dpi'];
                        $orig_h *= $this->img_dpi / $sizesarray['set-dpi'];
                    } else if (preg_match('/(\d+)dpi/i', $properties['BACKGROUND-IMAGE-RESOLUTION'], $m)) {
                        $dpi = $m[1];
                        if ($dpi > 0) {
                            $orig_w *= $this->img_dpi / $dpi;
                            $orig_h *= $this->img_dpi / $dpi;
                        }
                    }
                }
                $x_repeat = true;
                $y_repeat = true;
                if (isset($properties['BACKGROUND-REPEAT'])) {
                    if ($properties['BACKGROUND-REPEAT'] == 'no-repeat' || $properties['BACKGROUND-REPEAT'] == 'repeat-x') {
                        $y_repeat = false;
                    }
                    if ($properties['BACKGROUND-REPEAT'] == 'no-repeat' || $properties['BACKGROUND-REPEAT'] == 'repeat-y') {
                        $x_repeat = false;
                    }
                }
                $x_pos = 0;
                $y_pos = 0;
                if (isset($properties['BACKGROUND-POSITION'])) {
                    $ppos = preg_split('/\s+/', $properties['BACKGROUND-POSITION']);
                    $x_pos = $ppos[0];
                    $y_pos = $ppos[1];
                    if (!stristr($x_pos, '%')) {
                        $x_pos = $this->ConvertSize($x_pos, $maxwidth, $this->FontSize);
                    }
                    if (!stristr($y_pos, '%')) {
                        $y_pos = $this->ConvertSize($y_pos, $maxwidth, $this->FontSize);
                    }
                }
                if (isset($properties['BACKGROUND-IMAGE-RESIZE'])) {
                    $resize = $properties['BACKGROUND-IMAGE-RESIZE'];
                } else {
                    $resize = 0;
                }
                if (isset($properties['BACKGROUND-IMAGE-OPACITY'])) {
                    $opacity = $properties['BACKGROUND-IMAGE-OPACITY'];
                } else {
                    $opacity = 1;
                }
                return array('image_id' => $image_id, 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $x_pos, 'y_pos' => $y_pos, 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'resize' => $resize, 'opacity' => $opacity, 'itype' => $sizesarray['itype'], 'origin' => $origin, 'size' => $size);
            }
        }
        return false;
    }

    function Image($file, $x, $y, $w = 0, $h = 0, $type = '', $link = '', $paint = true, $constrain = true, $watermark = false, $shownoimg = true, $allowvector = true)
    {
        $orig_srcpath = $file;
        $this->GetFullPath($file);

        $info = $this->_getImage($file, true, $allowvector, $orig_srcpath);
        if (!$info && $paint) {
            $info = $this->_getImage($this->noImageFile);
            if ($info) {
                $file = $this->noImageFile;
                $w = ($info['w'] * (25.4 / $this->dpi));    // 14 x 16px
                $h = ($info['h'] * (25.4 / $this->dpi));    // 14 x 16px
            }
        }
        if (!$info) return false;
        //Automatic width and height calculation if needed
        if ($w == 0 and $h == 0) {
            /*-- IMAGES-WMF --*/
            if ($info['type'] == 'wmf') {
                // WMF units are twips (1/20pt)
                // divide by 20 to get points
                // divide by k to get user units
                $w = abs($info['w']) / (20 * _MPDFK);
                $h = abs($info['h']) / (20 * _MPDFK);
            } else
                /*-- END IMAGES-WMF --*/
                if ($info['type'] == 'svg') {
                    // returned SVG units are pts
                    // divide by k to get user units (mm)
                    $w = abs($info['w']) / _MPDFK;
                    $h = abs($info['h']) / _MPDFK;
                } else {
                    //Put image at default image dpi
                    $w = ($info['w'] / _MPDFK) * (72 / $this->img_dpi);
                    $h = ($info['h'] / _MPDFK) * (72 / $this->img_dpi);
                }
        }
        if ($w == 0) $w = abs($h * $info['w'] / $info['h']);
        if ($h == 0) $h = abs($w * $info['h'] / $info['w']);

        /*-- WATERMARK --*/
        if ($watermark) {
            $maxw = $this->w;
            $maxh = $this->h;
            // Size = D PF or array
            if (is_array($this->watermark_size)) {
                $w = $this->watermark_size[0];
                $h = $this->watermark_size[1];
            } else if (!is_string($this->watermark_size)) {
                $maxw -= $this->watermark_size * 2;
                $maxh -= $this->watermark_size * 2;
                $w = $maxw;
                $h = abs($w * $info['h'] / $info['w']);
                if ($h > $maxh) {
                    $h = $maxh;
                    $w = abs($h * $info['w'] / $info['h']);
                }
            } else if ($this->watermark_size == 'F') {
                if ($this->ColActive) {
                    $maxw = $this->w - ($this->DeflMargin + $this->DefrMargin);
                } else {
                    $maxw = $this->pgwidth;
                }
                $maxh = $this->h - ($this->tMargin + $this->bMargin);
                $w = $maxw;
                $h = abs($w * $info['h'] / $info['w']);
                if ($h > $maxh) {
                    $h = $maxh;
                    $w = abs($h * $info['w'] / $info['h']);
                }
            } else if ($this->watermark_size == 'P') {    // Default P
                $w = $maxw;
                $h = abs($w * $info['h'] / $info['w']);
                if ($h > $maxh) {
                    $h = $maxh;
                    $w = abs($h * $info['w'] / $info['h']);
                }
            }
            // Automatically resize to maximum dimensions of page if too large
            if ($w > $maxw) {
                $w = $maxw;
                $h = abs($w * $info['h'] / $info['w']);
            }
            if ($h > $maxh) {
                $h = $maxh;
                $w = abs($h * $info['w'] / $info['h']);
            }
            // Position
            if (is_array($this->watermark_pos)) {
                $x = $this->watermark_pos[0];
                $y = $this->watermark_pos[1];
            } else if ($this->watermark_pos == 'F') {    // centred on printable area
                if ($this->ColActive) {    // *COLUMNS*
                    if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {
                        $xadj = $this->DeflMargin - $this->DefrMargin;
                    }    // *COLUMNS*
                    else {
                        $xadj = 0;
                    }    // *COLUMNS*
                    $x = ($this->DeflMargin - $xadj + ($this->w - ($this->DeflMargin + $this->DefrMargin)) / 2) - ($w / 2);    // *COLUMNS*
                }    // *COLUMNS*
                else {    // *COLUMNS*
                    $x = ($this->lMargin + ($this->pgwidth) / 2) - ($w / 2);
                }    // *COLUMNS*
                $y = ($this->tMargin + ($this->h - ($this->tMargin + $this->bMargin)) / 2) - ($h / 2);
            } else {    // default P - centred on whole page
                $x = ($this->w / 2) - ($w / 2);
                $y = ($this->h / 2) - ($h / 2);
            }
            /*-- IMAGES-WMF --*/
            if ($info['type'] == 'wmf') {
                $sx = $w * _MPDFK / $info['w'];
                $sy = -$h * _MPDFK / $info['h'];
                $outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
            } else
                /*-- END IMAGES-WMF --*/
                if ($info['type'] == 'svg') {
                    $sx = $w * _MPDFK / $info['w'];
                    $sy = -$h * _MPDFK / $info['h'];
                    $outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
                } else {
                    $outstring = sprintf("q %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $w * _MPDFK, $h * _MPDFK, $x * _MPDFK, ($this->h - ($y + $h)) * _MPDFK, $info['i']);
                }

            if ($this->watermarkImgBehind) {
                $outstring = $this->watermarkImgAlpha . "\n" . $outstring . "\n" . $this->SetAlpha(1, 'Normal', true) . "\n";
                $this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', "\n" . $outstring . "\n" . '\\1', $this->pages[$this->page]);
            } else {
                $this->_out($outstring);
            }

            return 0;
        }    // end of IF watermark
        /*-- END WATERMARK --*/

        if ($constrain) {
            // Automatically resize to maximum dimensions of page if too large
            if (isset($this->blk[$this->blklvl]['inner_width']) && $this->blk[$this->blklvl]['inner_width']) {
                $maxw = $this->blk[$this->blklvl]['inner_width'];
            } else {
                $maxw = $this->pgwidth;
            }
            if ($w > $maxw) {
                $w = $maxw;
                $h = abs($w * $info['h'] / $info['w']);
            }
            if ($h > $this->h - ($this->tMargin + $this->bMargin + 1)) {  // see below - +10 to avoid drawing too close to border of page
                $h = $this->h - ($this->tMargin + $this->bMargin + 1);
                if ($this->fullImageHeight) {
                    $h = $this->fullImageHeight;
                }
                $w = abs($h * $info['w'] / $info['h']);
            }


            //Avoid drawing out of the paper(exceeding width limits).
            //if ( ($x + $w) > $this->fw ) {
            if (($x + $w) > $this->w) {
                $x = $this->lMargin;
                $y += 5;
            }

            $changedpage = false;
            $oldcolumn = $this->CurrCol;
            //Avoid drawing out of the page.
            if ($y + $h > $this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
                $this->AddPage($this->CurOrientation);
                // Added to correct for OddEven Margins
                $x = $x + $this->MarginCorrection;
                $y = $this->tMargin;    // mPDF 5.7.3
                $changedpage = true;
            }
            /*-- COLUMNS --*/
            // COLS
            // COLUMN CHANGE
            if ($this->CurrCol != $oldcolumn) {
                $y = $this->y0;
                $x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
                $this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
            }
            /*-- END COLUMNS --*/
        }    // end of IF constrain

        /*-- IMAGES-WMF --*/
        if ($info['type'] == 'wmf') {
            $sx = $w * _MPDFK / $info['w'];
            $sy = -$h * _MPDFK / $info['h'];
            $outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
        } else
            /*-- END IMAGES-WMF --*/
            if ($info['type'] == 'svg') {
                $sx = $w * _MPDFK / $info['w'];
                $sy = -$h * _MPDFK / $info['h'];
                $outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
            } else {
                $outstring = sprintf("q %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $w * _MPDFK, $h * _MPDFK, $x * _MPDFK, ($this->h - ($y + $h)) * _MPDFK, $info['i']);
            }

        if ($paint) {
            $this->_out($outstring);
            if ($link) $this->Link($x, $y, $w, $h, $link);

            // Avoid writing text on top of the image. // THIS WAS OUTSIDE THE if ($paint) bit!!!!!!!!!!!!!!!!
            $this->y = $y + $h;
        }

        //Return width-height array
        $sizesarray['WIDTH'] = $w;
        $sizesarray['HEIGHT'] = $h;
        $sizesarray['X'] = $x; //Position before painting image
        $sizesarray['Y'] = $y; //Position before painting image
        $sizesarray['OUTPUT'] = $outstring;

        $sizesarray['IMAGE_ID'] = $info['i'];
        $sizesarray['itype'] = $info['type'];
        $sizesarray['set-dpi'] = $info['set-dpi'];
        return $sizesarray;
    }

    function GetFullPath(&$path, $basepath = '')
    {
        // When parsing CSS need to pass temporary basepath - so links are relative to current stylesheet
        if (!$basepath) {
            $basepath = $this->basepath;
        }
        //Fix path value
        $path = str_replace("\\", "/", $path); //If on Windows
        // mPDF 5.7.2
        if (substr($path, 0, 2) == "//") {
            $tr = parse_url($basepath);
            $path = $tr['scheme'] . ':' . $path;
        }
        $regexp = '|^./|';    // Inadvertently corrects "./path/etc" and "//www.domain.com/etc"
        $path = preg_replace($regexp, '', $path);


        if (substr($path, 0, 1) == '#') {
            return;
        }
        // mPDF 5.7.4
        if (substr($path, 0, 7) == "mailto:") {
            return;
        }
        if (substr($path, 0, 3) == "../") { //It is a Relative Link
            $backtrackamount = substr_count($path, "../");
            $maxbacktrack = substr_count($basepath, "/") - 3;    // mPDF 5.6.18
            $filepath = str_replace("../", '', $path);
            $path = $basepath;
            //If it is an invalid relative link, then make it go to directory root
            if ($backtrackamount > $maxbacktrack) $backtrackamount = $maxbacktrack;
            //Backtrack some directories
            for ($i = 0; $i < $backtrackamount + 1; $i++) $path = substr($path, 0, strrpos($path, "/"));
            $path = $path . "/" . $filepath; //Make it an absolute path
        } else if (strpos($path, ":/") === false || strpos($path, ":/") > 10) { //It is a Local Link
            if (substr($path, 0, 1) == "/") {
                $tr = parse_url($basepath);
                // mPDF 5.7.2
                $root = '';
                if (!empty($tr['scheme'])) {
                    $root .= $tr['scheme'] . '://';
                }
                $root .= $tr['host'];
                $root .= ($tr['port'] ? (':' . $tr['port']) : '');    // mPDF 5.7.3
                $path = $root . $path;
            } else {
                $path = $basepath . $path;
            }
        }
        //Do nothing if it is an Absolute Link
    }

    function _getImage(&$file, $firsttime = true, $allowvector = true, $orig_srcpath = false)
    {
        // firsttime i.e. whether to add to this->images - use false when calling iteratively
        // Image Data passed directly as var:varname
        if (preg_match('/var:\s*(.*)/', $file, $v)) {
            $data = $this->{$v[1]};
            $file = md5($data);
        }
        if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/', $file, $v)) {
            $type = $v[1];
            $data = base64_decode($v[2]);
            $file = md5($data);
        }

        // mPDF 5.7.4 URLs
        if ($firsttime && $file && substr($file, 0, 5) != 'data:') {
            $file = str_replace(" ", "%20", $file);
        }
        if ($firsttime && $orig_srcpath) {
            // If orig_srcpath is a relative file path (and not a URL), then it needs to be URL decoded
            if (substr($orig_srcpath, 0, 5) != 'data:') {
                $orig_srcpath = str_replace(" ", "%20", $orig_srcpath);
            }
            if (!preg_match('/^(http|ftp)/', $orig_srcpath)) {
                $orig_srcpath = urldecode_parts($orig_srcpath);
            }
        }


        $ppUx = 0;
        if ($orig_srcpath && isset($this->images[$orig_srcpath])) {
            $file = $orig_srcpath;
            return $this->images[$orig_srcpath];
        }
        if (isset($this->images[$file])) {
            return $this->images[$file];
        } else if ($orig_srcpath && isset($this->formobjects[$orig_srcpath])) {
            $file = $orig_srcpath;
            return $this->formobjects[$file];
        } else if (isset($this->formobjects[$file])) {
            return $this->formobjects[$file];
        } // Save re-trying image URL's which have already failed
        else if ($firsttime && isset($this->failedimages[$file])) {
            return $this->_imageError($file, $firsttime, '');
        }
        if (empty($data)) {
            $type = '';
            $data = '';

            if ($orig_srcpath && $this->basepathIsLocal && $check = @fopen($orig_srcpath, "rb")) {
                fclose($check);
                $file = $orig_srcpath;
                $data = file_get_contents($file);
                $type = $this->_imageTypeFromString($data);
            }
            if (!$data && $check = @fopen($file, "rb")) {
                fclose($check);
                $data = file_get_contents($file);
                $type = $this->_imageTypeFromString($data);
            }
            if ((!$data || !$type) && !ini_get('allow_url_fopen')) {    // only worth trying if remote file and !ini_get('allow_url_fopen')
                $this->file_get_contents_by_socket($file, $data);    // needs full url?? even on local (never needed for local)
                if ($data) {
                    $type = $this->_imageTypeFromString($data);
                }
            }
            if ((!$data || !$type) && function_exists("curl_init")) {    // mPDF 5.7.4
                $this->file_get_contents_by_curl($file, $data);        // needs full url?? even on local (never needed for local)
                if ($data) {
                    $type = $this->_imageTypeFromString($data);
                }
            }

        }
        if (!$data) {
            return $this->_imageError($file, $firsttime, 'Could not find image file');
        }
        if (empty($type)) {
            $type = $this->_imageTypeFromString($data);
        }
        if (($type == 'wmf' || $type == 'svg') && !$allowvector) {
            return $this->_imageError($file, $firsttime, 'WMF or SVG image file not supported in this context');
        }

        // SVG
        if ($type == 'svg') {
            if (!class_exists('SVG', false)) {
                include(_MPDF_PATH . 'classes/svg.php');
            }
            $svg = new SVG($this);
            $family = $this->FontFamily;
            $style = $this->FontStyle;
            $size = $this->FontSizePt;
            $info = $svg->ImageSVG($data);
            //Restore font
            if ($family) $this->SetFont($family, $style, $size, false);
            if (!$info) {
                return $this->_imageError($file, $firsttime, 'Error parsing SVG file');
            }
            $info['type'] = 'svg';
            $info['i'] = count($this->formobjects) + 1;
            $this->formobjects[$file] = $info;
            return $info;
        }

        // JPEG
        if ($type == 'jpeg' || $type == 'jpg') {
            $hdr = $this->_jpgHeaderFromString($data);
            if (!$hdr) {
                return $this->_imageError($file, $firsttime, 'Error parsing JPG header');
            }
            $a = $this->_jpgDataFromHeader($hdr);
            $j = strpos($data, 'JFIF');
            if ($j) {
                //Read resolution
                $unitSp = ord(substr($data, ($j + 7), 1));
                if ($unitSp > 0) {
                    $ppUx = $this->_twobytes2int(substr($data, ($j + 8), 2));    // horizontal pixels per meter, usually set to zero
                    if ($unitSp == 2) {    // = dots per cm (if == 1 set as dpi)
                        $ppUx = round($ppUx / 10 * 25.4);
                    }
                }
            }
            if ($a[2] == 'DeviceCMYK' && (($this->PDFA && $this->restrictColorSpace != 3) || $this->restrictColorSpace == 2)) {
                // convert to RGB image
                if (!function_exists("gd_info")) {
                    $this->Error("JPG image may not use CMYK color space (" . $file . ").");
                }
                if ($this->PDFA && !$this->PDFAauto) {
                    $this->PDFAXwarnings[] = "JPG image may not use CMYK color space - " . $file . " - (Image converted to RGB. NB This will alter the colour profile of the image.)";
                }
                $im = @imagecreatefromstring($data);
                if ($im) {
                    $tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
                    imageinterlace($im, false);
                    $check = @imagepng($im, $tempfile);
                    if (!$check) {
                        return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse JPG(CMYK) image');
                    }
                    $info = $this->_getImage($tempfile, false);
                    if (!$info) {
                        return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse JPG(CMYK) image');
                    }
                    imagedestroy($im);
                    unlink($tempfile);
                    $info['type'] = 'jpg';
                    if ($firsttime) {
                        $info['i'] = count($this->images) + 1;
                        $this->images[$file] = $info;
                    }
                    return $info;
                } else {
                    return $this->_imageError($file, $firsttime, 'Error creating GD image file from JPG(CMYK) image');
                }
            } else if ($a[2] == 'DeviceRGB' && ($this->PDFX || $this->restrictColorSpace == 3)) {
                // Convert to CMYK image stream - nominally returned as type='png'
                $info = $this->_convImage($data, $a[2], 'DeviceCMYK', $a[0], $a[1], $ppUx, false);
                if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                    $this->PDFAXwarnings[] = "JPG image may not use RGB color space - " . $file . " - (Image converted to CMYK. NB This will alter the colour profile of the image.)";
                }
            } else if (($a[2] == 'DeviceRGB' || $a[2] == 'DeviceCMYK') && $this->restrictColorSpace == 1) {
                // Convert to Grayscale image stream - nominally returned as type='png'
                $info = $this->_convImage($data, $a[2], 'DeviceGray', $a[0], $a[1], $ppUx, false);
            } else {
                $info = array('w' => $a[0], 'h' => $a[1], 'cs' => $a[2], 'bpc' => $a[3], 'f' => 'DCTDecode', 'data' => $data, 'type' => 'jpg');
                if ($ppUx) {
                    $info['set-dpi'] = $ppUx;
                }
            }
            if (!$info) {
                return $this->_imageError($file, $firsttime, 'Error parsing or converting JPG image');
            }

            if ($firsttime) {
                $info['i'] = count($this->images) + 1;
                $this->images[$file] = $info;
            }
            return $info;
        } // PNG
        else if ($type == 'png') {
            //Check signature
            if (substr($data, 0, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10)) {
                return $this->_imageError($file, $firsttime, 'Error parsing PNG identifier');
            }
            //Read header chunk
            if (substr($data, 12, 4) != 'IHDR') {
                return $this->_imageError($file, $firsttime, 'Incorrect PNG file (no IHDR block found)');
            }

            $w = $this->_fourbytes2int(substr($data, 16, 4));
            $h = $this->_fourbytes2int(substr($data, 20, 4));
            $bpc = ord(substr($data, 24, 1));
            $errpng = false;
            $pngalpha = false;
            if ($bpc > 8) {
                $errpng = 'not 8-bit depth';
            }
            $ct = ord(substr($data, 25, 1));
            if ($ct == 0) {
                $colspace = 'DeviceGray';
            } elseif ($ct == 2) {
                $colspace = 'DeviceRGB';
            } elseif ($ct == 3) {
                $colspace = 'Indexed';
            } elseif ($ct == 4) {
                $colspace = 'DeviceGray';
                $errpng = 'alpha channel';
                $pngalpha = true;
            } else {
                $colspace = 'DeviceRGB';
                $errpng = 'alpha channel';
                $pngalpha = true;
            }
            if (ord(substr($data, 26, 1)) != 0) {
                $errpng = 'compression method';
            }
            if (ord(substr($data, 27, 1)) != 0) {
                $errpng = 'filter method';
            }
            if (ord(substr($data, 28, 1)) != 0) {
                $errpng = 'interlaced file';
            }
            $j = strpos($data, 'pHYs');
            if ($j) {
                //Read resolution
                $unitSp = ord(substr($data, ($j + 12), 1));
                if ($unitSp == 1) {
                    $ppUx = $this->_fourbytes2int(substr($data, ($j + 4), 4));    // horizontal pixels per meter, usually set to zero
                    $ppUx = round($ppUx / 1000 * 25.4);
                }
            }
            if (($colspace == 'DeviceRGB' || $colspace == 'Indexed') && ($this->PDFX || $this->restrictColorSpace == 3)) {
                // Convert to CMYK image stream - nominally returned as type='png'
                $info = $this->_convImage($data, $colspace, 'DeviceCMYK', $w, $h, $ppUx, $pngalpha);
                if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                    $this->PDFAXwarnings[] = "PNG image may not use RGB color space - " . $file . " - (Image converted to CMYK. NB This will alter the colour profile of the image.)";
                }
            } else if (($colspace == 'DeviceRGB' || $colspace == 'Indexed') && $this->restrictColorSpace == 1) {
                // Convert to Grayscale image stream - nominally returned as type='png'
                $info = $this->_convImage($data, $colspace, 'DeviceGray', $w, $h, $ppUx, $pngalpha);
            } else if (($this->PDFA || $this->PDFX) && $pngalpha) {
                // Remove alpha channel
                if ($this->restrictColorSpace == 1) {    // Grayscale
                    $info = $this->_convImage($data, $colspace, 'DeviceGray', $w, $h, $ppUx, $pngalpha);
                } else if ($this->restrictColorSpace == 3) {    // CMYK
                    $info = $this->_convImage($data, $colspace, 'DeviceCMYK', $w, $h, $ppUx, $pngalpha);
                } else if ($this->PDFA) {    // RGB
                    $info = $this->_convImage($data, $colspace, 'DeviceRGB', $w, $h, $ppUx, $pngalpha);
                }
                if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                    $this->PDFAXwarnings[] = "Transparency (alpha channel) not permitted in PDFA or PDFX files - " . $file . " - (Image converted to one without transparency.)";
                }
            } else if ($errpng || $pngalpha) {
                if (function_exists('gd_info')) {
                    $gd = gd_info();
                } else {
                    $gd = array();
                }
                if (!isset($gd['PNG Support'])) {
                    return $this->_imageError($file, $firsttime, 'GD library required for PNG image (' . $errpng . ')');
                }
                $im = imagecreatefromstring($data);
                if (!$im) {
                    return $this->_imageError($file, $firsttime, 'Error creating GD image from PNG file (' . $errpng . ')');
                }
                $w = imagesx($im);
                $h = imagesy($im);
                if ($im) {
                    $tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
                    // Alpha channel set
                    if ($pngalpha) {
                        if ($this->PDFA) {
                            $this->Error("PDFA1-b does not permit images with alpha channel transparency (" . $file . ").");
                        }
                        $imgalpha = imagecreate($w, $h);
                        // generate gray scale pallete
                        for ($c = 0; $c < 256; ++$c) {
                            ImageColorAllocate($imgalpha, $c, $c, $c);
                        }
                        // extract alpha channel
                        for ($xpx = 0; $xpx < $w; ++$xpx) {
                            for ($ypx = 0; $ypx < $h; ++$ypx) {
                                $alpha = (imagecolorat($im, $xpx, $ypx) & 0x7F000000) >> 24;
                                // mPDF 5.7.2
                                if ($alpha < 127) {
                                    imagesetpixel($imgalpha, $xpx, $ypx, (255 - ($alpha * 2)));
                                }
                            }
                        }
                        // create temp alpha file
                        $tempfile_alpha = _MPDF_TEMP_PATH . '_tempMskPNG' . md5($file) . RAND(1, 10000) . '.png';
                        if (!is_writable(_MPDF_TEMP_PATH)) {    // mPDF 5.7.2
                            ob_start();
                            $check = @imagepng($imgalpha);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
                            }
                            imagedestroy($imgalpha);
                            $this->_tempimg = ob_get_contents();
                            $this->_tempimglnk = 'var:_tempimg';
                            ob_end_clean();
                            // extract image without alpha channel
                            $imgplain = imagecreatetruecolor($w, $h);
                            imagealphablending($imgplain, false);    // mPDF 5.7.2
                            imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);
                            // create temp image file
                            $minfo = $this->_getImage($this->_tempimglnk, false);
                            if (!$minfo) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
                            }
                            ob_start();
                            $check = @imagepng($imgplain);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
                            }
                            $this->_tempimg = ob_get_contents();
                            $this->_tempimglnk = 'var:_tempimg';
                            ob_end_clean();
                            $info = $this->_getImage($this->_tempimglnk, false);
                            if (!$info) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
                            }
                            imagedestroy($imgplain);
                            $imgmask = count($this->images) + 1;
                            $minfo['cs'] = 'DeviceGray';
                            $minfo['i'] = $imgmask;
                            $this->images[$tempfile_alpha] = $minfo;

                        } else {
                            $check = @imagepng($imgalpha, $tempfile_alpha);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile_alpha . ') parsing PNG image with alpha channel (' . $errpng . ')');
                            }
                            imagedestroy($imgalpha);

                            // extract image without alpha channel
                            $imgplain = imagecreatetruecolor($w, $h);
                            imagealphablending($imgplain, false);    // mPDF 5.7.2
                            imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);

                            // create temp image file
                            $check = @imagepng($imgplain, $tempfile);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile . ') parsing PNG image with alpha channel (' . $errpng . ')');
                            }
                            imagedestroy($imgplain);
                            // embed mask image
                            $minfo = $this->_getImage($tempfile_alpha, false);
                            unlink($tempfile_alpha);
                            if (!$minfo) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile_alpha . ') created with GD library to parse PNG image');
                            }
                            $imgmask = count($this->images) + 1;
                            $minfo['cs'] = 'DeviceGray';
                            $minfo['i'] = $imgmask;
                            $this->images[$tempfile_alpha] = $minfo;
                            // embed image, masked with previously embedded mask
                            $info = $this->_getImage($tempfile, false);
                            unlink($tempfile);
                            if (!$info) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse PNG image');
                            }

                        }
                        $info['masked'] = $imgmask;
                        if ($ppUx) {
                            $info['set-dpi'] = $ppUx;
                        }
                        $info['type'] = 'png';
                        if ($firsttime) {
                            $info['i'] = count($this->images) + 1;
                            $this->images[$file] = $info;
                        }
                        return $info;
                    } else {    // No alpha/transparency set
                        imagealphablending($im, false);
                        imagesavealpha($im, false);
                        imageinterlace($im, false);
                        if (!is_writable($tempfile)) {
                            ob_start();
                            $check = @imagepng($im);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
                            }
                            $this->_tempimg = ob_get_contents();
                            $this->_tempimglnk = 'var:_tempimg';
                            ob_end_clean();
                            $info = $this->_getImage($this->_tempimglnk, false);
                            if (!$info) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
                            }
                            imagedestroy($im);
                        } else {
                            $check = @imagepng($im, $tempfile);
                            if (!$check) {
                                return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile . ') parsing PNG image (' . $errpng . ')');
                            }
                            imagedestroy($im);
                            $info = $this->_getImage($tempfile, false);
                            unlink($tempfile);
                            if (!$info) {
                                return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse PNG image');
                            }
                        }
                        if ($ppUx) {
                            $info['set-dpi'] = $ppUx;
                        }
                        $info['type'] = 'png';
                        if ($firsttime) {
                            $info['i'] = count($this->images) + 1;
                            $this->images[$file] = $info;
                        }
                        return $info;
                    }
                }
            } else {
                $parms = '/DecodeParms <</Predictor 15 /Colors ' . ($ct == 2 ? 3 : 1) . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w . '>>';
                //Scan chunks looking for palette, transparency and image data
                $pal = '';
                $trns = '';
                $pngdata = '';
                $p = 33;
                do {
                    $n = $this->_fourbytes2int(substr($data, $p, 4));
                    $p += 4;
                    $type = substr($data, $p, 4);
                    $p += 4;
                    if ($type == 'PLTE') {
                        //Read palette
                        $pal = substr($data, $p, $n);
                        $p += $n;
                        $p += 4;
                    } elseif ($type == 'tRNS') {
                        //Read transparency info
                        $t = substr($data, $p, $n);
                        $p += $n;
                        if ($ct == 0) $trns = array(ord(substr($t, 1, 1)));
                        elseif ($ct == 2) $trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
                        else {
                            $pos = strpos($t, chr(0));
                            if (is_int($pos)) $trns = array($pos);
                        }
                        $p += 4;
                    } elseif ($type == 'IDAT') {
                        $pngdata .= substr($data, $p, $n);
                        $p += $n;
                        $p += 4;
                    } elseif ($type == 'IEND') {
                        break;
                    } else if (preg_match('/[a-zA-Z]{4}/', $type)) {
                        $p += $n + 4;
                    } else {
                        return $this->_imageError($file, $firsttime, 'Error parsing PNG image data');
                    }
                } while ($n);
                if (!$pngdata) {
                    return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - no IDAT data found');
                }
                if ($colspace == 'Indexed' and empty($pal)) {
                    return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - missing colour palette');
                }
                $info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'parms' => $parms, 'pal' => $pal, 'trns' => $trns, 'data' => $pngdata);
                $info['type'] = 'png';
                if ($ppUx) {
                    $info['set-dpi'] = $ppUx;
                }
            }

            if (!$info) {
                return $this->_imageError($file, $firsttime, 'Error parsing or converting PNG image');
            }

            if ($firsttime) {
                $info['i'] = count($this->images) + 1;
                $this->images[$file] = $info;
            }
            return $info;
        } // GIF
        else if ($type == 'gif') {
            if (function_exists('gd_info')) {
                $gd = gd_info();
            } else {
                $gd = array();
            }
            if (isset($gd['GIF Read Support']) && $gd['GIF Read Support']) {
                $im = @imagecreatefromstring($data);
                if ($im) {
                    $tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
                    imagealphablending($im, false);
                    imagesavealpha($im, false);
                    imageinterlace($im, false);
                    if (!is_writable($tempfile)) {
                        ob_start();
                        $check = @imagepng($im);
                        if (!$check) {
                            return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse GIF image');
                        }
                        $this->_tempimg = ob_get_contents();
                        $this->_tempimglnk = 'var:_tempimg';
                        ob_end_clean();
                        $info = $this->_getImage($this->_tempimglnk, false);
                        if (!$info) {
                            return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse GIF image');
                        }
                        imagedestroy($im);
                    } else {
                        $check = @imagepng($im, $tempfile);
                        if (!$check) {
                            return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse GIF image');
                        }
                        $info = $this->_getImage($tempfile, false);
                        if (!$info) {
                            return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse GIF image');
                        }
                        imagedestroy($im);
                        unlink($tempfile);
                    }
                    $info['type'] = 'gif';
                    if ($firsttime) {
                        $info['i'] = count($this->images) + 1;
                        $this->images[$file] = $info;
                    }
                    return $info;
                } else {
                    return $this->_imageError($file, $firsttime, 'Error creating GD image file from GIF image');
                }
            }

            if (!class_exists('gif', false)) {
                include_once(_MPDF_PATH . 'classes/gif.php');
            }
            $gif = new CGIF();

            $h = 0;
            $w = 0;
            $gif->loadFile($data, 0);

            if (isset($gif->m_img->m_gih->m_bLocalClr) && $gif->m_img->m_gih->m_bLocalClr) {
                $nColors = $gif->m_img->m_gih->m_nTableSize;
                $pal = $gif->m_img->m_gih->m_colorTable->toString();
                if ((isset($bgColor)) and $bgColor != -1) {    // mPDF 5.7.3
                    $bgColor = $gif->m_img->m_gih->m_colorTable->colorIndex($bgColor);
                }
                $colspace = 'Indexed';
            } elseif (isset($gif->m_gfh->m_bGlobalClr) && $gif->m_gfh->m_bGlobalClr) {
                $nColors = $gif->m_gfh->m_nTableSize;
                $pal = $gif->m_gfh->m_colorTable->toString();
                if ((isset($bgColor)) and $bgColor != -1) {
                    $bgColor = $gif->m_gfh->m_colorTable->colorIndex($bgColor);
                }
                $colspace = 'Indexed';
            } else {
                $nColors = 0;
                $bgColor = -1;
                $colspace = 'DeviceGray';
                $pal = '';
            }

            $trns = '';
            if (isset($gif->m_img->m_bTrans) && $gif->m_img->m_bTrans && ($nColors > 0)) {
                $trns = array($gif->m_img->m_nTrans);
            }
            $gifdata = $gif->m_img->m_data;
            $w = $gif->m_gfh->m_nWidth;
            $h = $gif->m_gfh->m_nHeight;
            $gif->ClearData();

            if ($colspace == 'Indexed' and empty($pal)) {
                return $this->_imageError($file, $firsttime, 'Error parsing GIF image - missing colour palette');
            }
            if ($this->compress) {
                $gifdata = gzcompress($gifdata);
                $info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => 8, 'f' => 'FlateDecode', 'pal' => $pal, 'trns' => $trns, 'data' => $gifdata);
            } else {
                $info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => 8, 'pal' => $pal, 'trns' => $trns, 'data' => $gifdata);
            }
            $info['type'] = 'gif';
            if ($firsttime) {
                $info['i'] = count($this->images) + 1;
                $this->images[$file] = $info;
            }
            return $info;
        }

        /*-- IMAGES-BMP --*/
        // BMP (Windows Bitmap)
        else if ($type == 'bmp') {
            if (!class_exists('bmp', false)) {
                include(_MPDF_PATH . 'classes/bmp.php');
            }
            if (empty($this->bmp)) {
                $this->bmp = new bmp($this);
            }
            $info = $this->bmp->_getBMPimage($data, $file);
            if (isset($info['error'])) {
                return $this->_imageError($file, $firsttime, $info['error']);
            }
            if ($firsttime) {
                $info['i'] = count($this->images) + 1;
                $this->images[$file] = $info;
            }
            return $info;
        }
        /*-- END IMAGES-BMP --*/
        /*-- IMAGES-WMF --*/
        // WMF
        else if ($type == 'wmf') {
            if (!class_exists('wmf', false)) {
                include(_MPDF_PATH . 'classes/wmf.php');
            }
            if (empty($this->wmf)) {
                $this->wmf = new wmf($this);
            }
            $wmfres = $this->wmf->_getWMFimage($data);
            if ($wmfres[0] == 0) {
                if ($wmfres[1]) {
                    return $this->_imageError($file, $firsttime, $wmfres[1]);
                }
                return $this->_imageError($file, $firsttime, 'Error parsing WMF image');
            }
            $info = array('x' => $wmfres[2][0], 'y' => $wmfres[2][1], 'w' => $wmfres[3][0], 'h' => $wmfres[3][1], 'data' => $wmfres[1]);
            $info['i'] = count($this->formobjects) + 1;
            $info['type'] = 'wmf';
            $this->formobjects[$file] = $info;
            return $info;
        }
        /*-- END IMAGES-WMF --*/

        // UNKNOWN TYPE - try GD imagecreatefromstring
        else {
            if (function_exists('gd_info')) {
                $gd = gd_info();
            } else {
                $gd = array();
            }
            if (isset($gd['PNG Support']) && $gd['PNG Support']) {
                $im = @imagecreatefromstring($data);
                if (!$im) {
                    return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised, and not supported by GD imagecreate');
                }
                $tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
                imagealphablending($im, false);
                imagesavealpha($im, false);
                imageinterlace($im, false);
                $check = @imagepng($im, $tempfile);
                if (!$check) {
                    return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse unknown image type');
                }
                $info = $this->_getImage($tempfile, false);
                imagedestroy($im);
                unlink($tempfile);
                if (!$info) {
                    return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse unknown image type');
                }
                $info['type'] = 'png';
                if ($firsttime) {
                    $info['i'] = count($this->images) + 1;
                    $this->images[$file] = $info;
                }
                return $info;
            }
        }

        return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised');
    }

    function _imageError($file, $firsttime, $msg)
    {
        // Save re-trying image URL's which have already failed
        $this->failedimages[$file] = true;
        if ($firsttime && ($this->showImageErrors || $this->debug)) {
            $this->Error("IMAGE Error (" . $file . "): " . $msg);
        }
        return false;
    }

    function _imageTypeFromString(&$data)
    {
        $type = '';
        if (substr($data, 6, 4) == 'JFIF' || substr($data, 6, 4) == 'Exif' || substr($data, 0, 2) == chr(255) . chr(216)) { // 0xFF 0xD8	// mpDF 5.7.2
            $type = 'jpeg';
        } else if (substr($data, 0, 6) == "GIF87a" || substr($data, 0, 6) == "GIF89a") {
            $type = 'gif';
        } else if (substr($data, 0, 8) == chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10)) {
            $type = 'png';
        } /*-- IMAGES-WMF --*/
        else if (substr($data, 0, 4) == chr(215) . chr(205) . chr(198) . chr(154)) {
            $type = 'wmf';
        } /*-- END IMAGES-WMF --*/
        else if (preg_match('/<svg.*<\/svg>/is', $data)) {
            $type = 'svg';
        } // BMP images
        else if (substr($data, 0, 2) == "BM") {
            $type = 'bmp';
        }
        return $type;
    }

    function file_get_contents_by_socket($url, &$data)
    {
        // mPDF 5.7.3
        $timeout = 1;
        $p = parse_url($url);
        $file = $p['path'];
        if ($p['scheme'] == 'https') {
            $prefix = 'ssl://';
            $port = ($p['port'] ? $p['port'] : 443);
        } else {
            $prefix = '';
            $port = ($p['port'] ? $p['port'] : 80);
        }
        if ($p['query']) {
            $file .= '?' . $p['query'];
        }
        if (!($fh = @fsockopen($prefix . $p['host'], $port, $errno, $errstr, $timeout))) {
            return false;
        }

        $getstring =
            "GET " . $file . " HTTP/1.0 \r\n" .
            "Host: " . $p['host'] . " \r\n" .
            "Connection: close\r\n\r\n";
        fwrite($fh, $getstring);
        // Get rid of HTTP header
        $s = fgets($fh, 1024);
        if (!$s) {
            return false;
        }
        $httpheader .= $s;
        while (!feof($fh)) {
            $s = fgets($fh, 1024);
            if ($s == "\r\n") {
                break;
            }
        }
        $data = '';
        while (!feof($fh)) {
            $data .= fgets($fh, 1024);
        }
        fclose($fh);
    }

    function file_get_contents_by_curl($url, &$data)
    {
        $timeout = 5;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');    // mPDF 5.7.4
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
    }

    function _jpgHeaderFromString(&$data)
    {
        $p = 4;
        $p += $this->_twobytes2int(substr($data, $p, 2));    // Length of initial marker block
        $marker = substr($data, $p, 2);
        while ($marker != chr(255) . chr(192) && $marker != chr(255) . chr(194) && $p < strlen($data)) {
            // Start of frame marker (FFC0) or (FFC2) mPDF 4.4.004
            $p += ($this->_twobytes2int(substr($data, $p + 2, 2))) + 2;    // Length of marker block
            $marker = substr($data, $p, 2);
        }
        if ($marker != chr(255) . chr(192) && $marker != chr(255) . chr(194)) {
            return false;
        }
        return substr($data, $p + 2, 10);
    }

    function _twobytes2int($s)
    {
        //Read a 2-byte integer from string
        return (ord(substr($s, 0, 1)) << 8) + ord(substr($s, 1, 1));
    }

    function _jpgDataFromHeader($hdr)
    {
        $bpc = ord(substr($hdr, 2, 1));
        if (!$bpc) {
            $bpc = 8;
        }
        $h = $this->_twobytes2int(substr($hdr, 3, 2));
        $w = $this->_twobytes2int(substr($hdr, 5, 2));
        $channels = ord(substr($hdr, 7, 1));
        if ($channels == 3) {
            $colspace = 'DeviceRGB';
        } elseif ($channels == 4) {
            $colspace = 'DeviceCMYK';
        } else {
            $colspace = 'DeviceGray';
        }
        return array($w, $h, $colspace, $bpc);
    }

    function _convImage(&$data, $colspace, $targetcs, $w, $h, $dpi, $mask)
    {
        if ($this->PDFA || $this->PDFX) {
            $mask = false;
        }
        $im = @imagecreatefromstring($data);
        $info = array();
        if ($im) {
            $imgdata = '';
            $mimgdata = '';
            $minfo = array();
            //Read transparency info
            $trns = array();
            $trnsrgb = false;
            if (!$this->PDFA && !$this->PDFX) {
                $p = strpos($data, 'tRNS');
                if ($p) {
                    $n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
                    $t = substr($data, ($p + 4), $n);
                    if ($colspace == 'DeviceGray') {
                        $trns = array(ord(substr($t, 1, 1)));
                        $trnsrgb = array($trns[0], $trns[0], $trns[0]);
                    } else if ($colspace == 'DeviceRGB') {
                        $trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
                        $trnsrgb = $trns;
                        if ($targetcs == 'DeviceCMYK') {
                            $col = $this->rgb2cmyk(array(3, $trns[0], $trns[1], $trns[2]));
                            $c1 = intval($col[1] * 2.55);
                            $c2 = intval($col[2] * 2.55);
                            $c3 = intval($col[3] * 2.55);
                            $c4 = intval($col[4] * 2.55);
                            $trns = array($c1, $c2, $c3, $c4);
                        } else if ($targetcs == 'DeviceGray') {
                            $c = intval(($trns[0] * .21) + ($trns[1] * .71) + ($trns[2] * .07));
                            $trns = array($c);
                        }
                    } else {    // Indexed
                        $pos = strpos($t, chr(0));
                        if (is_int($pos)) {
                            $pal = imagecolorsforindex($im, $pos);
                            $r = $pal['red'];
                            $g = $pal['green'];
                            $b = $pal['blue'];
                            $trns = array($r, $g, $b);    // ****
                            $trnsrgb = $trns;
                            if ($targetcs == 'DeviceCMYK') {
                                $col = $this->rgb2cmyk(array(3, $r, $g, $b));
                                $c1 = intval($col[1] * 2.55);
                                $c2 = intval($col[2] * 2.55);
                                $c3 = intval($col[3] * 2.55);
                                $c4 = intval($col[4] * 2.55);
                                $trns = array($c1, $c2, $c3, $c4);
                            } else if ($targetcs == 'DeviceGray') {
                                $c = intval(($r * .21) + ($g * .71) + ($b * .07));
                                $trns = array($c);
                            }
                        }
                    }
                }
            }
            for ($i = 0; $i < $h; $i++) {
                for ($j = 0; $j < $w; $j++) {
                    $rgb = imagecolorat($im, $j, $i);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    if ($colspace == 'Indexed') {
                        $pal = imagecolorsforindex($im, $rgb);
                        $r = $pal['red'];
                        $g = $pal['green'];
                        $b = $pal['blue'];
                    }

                    if ($targetcs == 'DeviceCMYK') {
                        $col = $this->rgb2cmyk(array(3, $r, $g, $b));
                        $c1 = intval($col[1] * 2.55);
                        $c2 = intval($col[2] * 2.55);
                        $c3 = intval($col[3] * 2.55);
                        $c4 = intval($col[4] * 2.55);
                        if ($trnsrgb) {
                            // original pixel was not set as transparent but processed color does match
                            if ($trnsrgb != array($r, $g, $b) && $trns == array($c1, $c2, $c3, $c4)) {
                                if ($c4 == 0) {
                                    $c4 = 1;
                                } else {
                                    $c4--;
                                }
                            }
                        }
                        $imgdata .= chr($c1) . chr($c2) . chr($c3) . chr($c4);
                    } else if ($targetcs == 'DeviceGray') {
                        $c = intval(($r * .21) + ($g * .71) + ($b * .07));
                        if ($trnsrgb) {
                            // original pixel was not set as transparent but processed color does match
                            if ($trnsrgb != array($r, $g, $b) && $trns == array($c)) {
                                if ($c == 0) {
                                    $c = 1;
                                } else {
                                    $c--;
                                }
                            }
                        }
                        $imgdata .= chr($c);
                    } else if ($targetcs == 'DeviceRGB') {
                        $imgdata .= chr($r) . chr($g) . chr($b);
                    }
                    if ($mask) {
                        // mPDF 5.7.2 Gamma correction
                        $alpha = ($rgb & 0x7F000000) >> 24;
                        if ($alpha < 127) {
                            $mimgdata .= chr(255 - ($alpha * 2));
                        } else {
                            $mimgdata .= chr(0);
                        }
                    }
                }
            }

            if ($targetcs == 'DeviceGray') {
                $ncols = 1;
            } else if ($targetcs == 'DeviceRGB') {
                $ncols = 3;
            } else if ($targetcs == 'DeviceCMYK') {
                $ncols = 4;
            }

            $imgdata = gzcompress($imgdata);
            $info = array('w' => $w, 'h' => $h, 'cs' => $targetcs, 'bpc' => 8, 'f' => 'FlateDecode', 'data' => $imgdata, 'type' => 'png',
                'parms' => '/DecodeParms <</Colors ' . $ncols . ' /BitsPerComponent 8 /Columns ' . $w . '>>');
            if ($dpi) {
                $info['set-dpi'] = $dpi;
            }
            if ($mask) {
                $mimgdata = gzcompress($mimgdata);
                $minfo = array('w' => $w, 'h' => $h, 'cs' => 'DeviceGray', 'bpc' => 8, 'f' => 'FlateDecode', 'data' => $mimgdata, 'type' => 'png',
                    'parms' => '/DecodeParms <</Colors ' . $ncols . ' /BitsPerComponent 8 /Columns ' . $w . '>>');
                if ($dpi) {
                    $minfo['set-dpi'] = $dpi;
                }
                $tempfile = '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
                $imgmask = count($this->images) + 1;
                $minfo['i'] = $imgmask;
                $this->images[$tempfile] = $minfo;
                $info['masked'] = $imgmask;
            } else if ($trns) {
                $info['trns'] = $trns;
            }
            imagedestroy($im);
        }
        return $info;
    }

    function _fourbytes2int($s)
    {
        //Read a 4-byte integer from string
        return (ord($s[0]) << 24) + (ord($s[1]) << 16) + (ord($s[2]) << 8) + ord($s[3]);
    }

    function SetAlpha($alpha, $bm = 'Normal', $return = false, $mode = 'B')
    {
// alpha: real value from 0 (transparent) to 1 (opaque)
// bm:    blend mode, one of the following:
//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
// set alpha for stroking (CA) and non-stroking (ca) operations
// mode determines F (fill) S (stroke) B (both)
        if (($this->PDFA || $this->PDFX) && $alpha != 1) {
            if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                $this->PDFAXwarnings[] = "Image opacity must be 100% (Opacity changed to 100%)";
            }
            $alpha = 1;
        }
        $a = array('BM' => '/' . $bm);
        if ($mode == 'F' || $mode == 'B') $a['ca'] = $alpha;    // mPDF 5.7.2
        if ($mode == 'S' || $mode == 'B') $a['CA'] = $alpha;    // mPDF 5.7.2
        $gs = $this->AddExtGState($a);
        if ($return) {
            return sprintf('/GS%d gs', $gs);
        } else {
            $this->_out(sprintf('/GS%d gs', $gs));
        }
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates);
        // check if graphics state already exists
        for ($i = 1; $i <= $n; $i++) {
            if (count($this->extgstates[$i]['parms']) == count($parms)) {
                $same = true;
                foreach ($this->extgstates[$i]['parms'] AS $k => $v) {
                    if (!isset($parms[$k]) || $parms[$k] != $v) {
                        $same = false;
                        break;
                    }
                }
                if ($same) {
                    return $i;
                }
            }
        }
        $n++;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    /*-- DIRECTW --*/

    function AcceptPageBreak()
    {
        if (count($this->cellBorderBuffer)) {
            $this->printcellbuffer();
        }    // *TABLES*
        /*-- COLUMNS --*/
        if ($this->ColActive == 1) {
            if ($this->CurrCol < $this->NbCol - 1) {
                //Go to the next column
                $this->CurrCol++;
                $this->SetCol($this->CurrCol);
                $this->y = $this->y0;
                $this->ChangeColumn = 1;    // Number (and direction) of columns changed +1, +2, -2 etc.
                // DIRECTIONALITY RTL
                if ($this->directionality == 'rtl') {
                    $this->ChangeColumn = -($this->ChangeColumn);
                }    // *RTL*

                //Stay on the page
                return false;
            } else {
                //Go back to the first column - NEW PAGE
                if (count($this->columnbuffer)) {
                    $this->printcolumnbuffer();
                }
                $this->SetCol(0);
                $this->y0 = $this->tMargin;
                $this->ChangeColumn = -($this->NbCol - 1);
                // DIRECTIONALITY RTL
                if ($this->directionality == 'rtl') {
                    $this->ChangeColumn = -($this->ChangeColumn);
                }    // *RTL*
                //Page break
                return true;
            }
        }
        /*-- END COLUMNS --*/
        /*-- TABLES --*/
        else if ($this->table_rotate) {
            if ($this->tablebuffer) {
                $this->printtablebuffer();
            }
            return true;
        } /*-- END TABLES --*/
        else {    // *COLUMNS*
            $this->ChangeColumn = 0;
            return $this->autoPageBreak;
        }    // *COLUMNS*
        return $this->autoPageBreak;
    }

    function printcellbuffer()
    {
        if (count($this->cellBorderBuffer)) {
            sort($this->cellBorderBuffer);
            foreach ($this->cellBorderBuffer AS $cbb) {
                $cba = unpack("A16dom/nbord/A1side/ns/dbw/a6ca/A10style/dx/dy/dw/dh/dmbl/dmbr/dmrt/dmrb/dmtl/dmtr/dmlt/dmlb/dcpd/dover/", $cbb);
                $side = $cba['side'];
                $details = array();
                $details[$side]['dom'] = (float)$cba['dom'];
                $details[$side]['s'] = $cba['s'];
                $details[$side]['w'] = $cba['bw'];
                $details[$side]['c'] = $cba['ca'];
                $details[$side]['style'] = trim($cba['style']);
                $details['mbw']['BL'] = $cba['mbl'];
                $details['mbw']['BR'] = $cba['mbr'];
                $details['mbw']['RT'] = $cba['mrt'];
                $details['mbw']['RB'] = $cba['mrb'];
                $details['mbw']['TL'] = $cba['mtl'];
                $details['mbw']['TR'] = $cba['mtr'];
                $details['mbw']['LT'] = $cba['mlt'];
                $details['mbw']['LB'] = $cba['mlb'];
                $details['cellposdom'] = $cba['cpd'];
                $details['p'] = $side;
                if ($cba['over'] == 1) {
                    $details[$side]['overlay'] = true;
                } else {
                    $details[$side]['overlay'] = false;
                }
                $this->_tableRect($cba['x'], $cba['y'], $cba['w'], $cba['h'], $cba['bord'], $details, false, false);

            }
            $this->cellBorderBuffer = array();
        }
    }

    /*-- END DIRECTW --*/

    function _tableRect($x, $y, $w, $h, $bord = -1, $details = array(), $buffer = false, $bSeparate = false, $cort = 'cell', $tablecorner = '', $bsv = 0, $bsh = 0)
    {
        $cellBorderOverlay = array();

        if ($bord == -1) {
            $this->Rect($x, $y, $w, $h);
        } else if ($this->simpleTables && ($cort == 'cell')) {
            $this->SetLineWidth($details['L']['w']);
            if ($details['L']['c']) {
                $this->SetDColor($details['L']['c']);
            } else {
                $this->SetDColor($this->ConvertColor(0));
            }
            $this->SetLineJoin(0);
            $this->Rect($x, $y, $w, $h);
        } else if ($bord) {
            if (!$bSeparate && $buffer) {
                $priority = 'LRTB';
                for ($p = 0; $p < strlen($priority); $p++) {
                    $side = $priority[$p];
                    $details['p'] = $side;

                    $dom = 0;
                    if (isset($details[$side]['w'])) {
                        $dom += ($details[$side]['w'] * 100000);
                    }
                    if (isset($details[$side]['style'])) {
                        $dom += (array_search($details[$side]['style'], $this->borderstyles) * 100);
                    }
                    if (isset($details[$side]['dom'])) {
                        $dom += ($details[$side]['dom'] * 10);
                    }

                    // Precedence to darker colours at joins
                    $coldom = 0;
                    if (isset($details[$side]['c']) && is_array($details[$side]['c'])) {
                        if ($details[$side]['c']{0} == 3) {    // RGB
                            $coldom = 10 - (((ord($details[$side]['c']{1}) * 1.00) + (ord($details[$side]['c']{2}) * 1.00) + (ord($details[$side]['c']{3}) * 1.00)) / 76.5);
                        }
                    } // 10 black - 0 white
                    if ($coldom) {
                        $dom += $coldom;
                    }
                    // Lastly precedence to RIGHT and BOTTOM cells at joins
                    if (isset($details['cellposdom'])) {
                        $dom += $details['cellposdom'];
                    }

                    $save = false;
                    if ($side == 'T' && $this->issetBorder($bord, _BORDER_TOP)) {
                        $cbord = _BORDER_TOP;
                        $save = true;
                    } else if ($side == 'L' && $this->issetBorder($bord, _BORDER_LEFT)) {
                        $cbord = _BORDER_LEFT;
                        $save = true;
                    } else if ($side == 'R' && $this->issetBorder($bord, _BORDER_RIGHT)) {
                        $cbord = _BORDER_RIGHT;
                        $save = true;
                    } else if ($side == 'B' && $this->issetBorder($bord, _BORDER_BOTTOM)) {
                        $cbord = _BORDER_BOTTOM;
                        $save = true;
                    }

                    if ($save) {
                        $this->cellBorderBuffer[] = pack("A16nCnda6A10d14",
                            str_pad(sprintf("%08.7f", $dom), 16, "0", STR_PAD_LEFT),
                            $cbord,
                            ord($side),
                            $details[$side]['s'],
                            $details[$side]['w'],
                            $details[$side]['c'],
                            $details[$side]['style'],
                            $x, $y, $w, $h,
                            $details['mbw']['BL'],
                            $details['mbw']['BR'],
                            $details['mbw']['RT'],
                            $details['mbw']['RB'],
                            $details['mbw']['TL'],
                            $details['mbw']['TR'],
                            $details['mbw']['LT'],
                            $details['mbw']['LB'],
                            $details['cellposdom'],
                            0
                        );
                        if ($details[$side]['style'] == 'ridge' || $details[$side]['style'] == 'groove' || $details[$side]['style'] == 'inset' || $details[$side]['style'] == 'outset' || $details[$side]['style'] == 'double') {
                            $details[$side]['overlay'] = true;
                            $this->cellBorderBuffer[] = pack("A16nCnda6A10d14",
                                str_pad(sprintf("%08.7f", ($dom + 4)), 16, "0", STR_PAD_LEFT),
                                $cbord,
                                ord($side),
                                $details[$side]['s'],
                                $details[$side]['w'],
                                $details[$side]['c'],
                                $details[$side]['style'],
                                $x, $y, $w, $h,
                                $details['mbw']['BL'],
                                $details['mbw']['BR'],
                                $details['mbw']['RT'],
                                $details['mbw']['RB'],
                                $details['mbw']['TL'],
                                $details['mbw']['TR'],
                                $details['mbw']['LT'],
                                $details['mbw']['LB'],
                                $details['cellposdom'],
                                1
                            );
                        }
                    }
                }
                return;
            }

            if (isset($details['p']) && strlen($details['p']) > 1) {
                $priority = $details['p'];
            } else {
                $priority = 'LTRB';
            }
            $Tw = 0;
            $Rw = 0;
            $Bw = 0;
            $Lw = 0;
            if (isset($details['T']['w'])) {
                $Tw = $details['T']['w'];
            }
            if (isset($details['R']['w'])) {
                $Rw = $details['R']['w'];
            }
            if (isset($details['B']['w'])) {
                $Bw = $details['B']['w'];
            }
            if (isset($details['L']['w'])) {
                $Lw = $details['L']['w'];
            }

            $x2 = $x + $w;
            $y2 = $y + $h;
            $oldlinewidth = $this->LineWidth;

            for ($p = 0; $p < strlen($priority); $p++) {
                $side = $priority[$p];
                $xadj = 0;
                $xadj2 = 0;
                $yadj = 0;
                $yadj2 = 0;
                $print = false;
                if ($Tw && $side == 'T' && $this->issetBorder($bord, _BORDER_TOP)) {    // TOP
                    $ly1 = $y;
                    $ly2 = $y;
                    $lx1 = $x;
                    $lx2 = $x2;
                    $this->SetLineWidth($Tw);
                    if ($cort == 'cell' || strpos($tablecorner, 'L') !== false) {
                        if ($Tw > $Lw) $xadj = ($Tw - $Lw) / 2;
                        if ($Tw < $Lw) $xadj = ($Tw + $Lw) / 2;
                    } else {
                        $xadj = $Tw / 2 - $bsh / 2;
                    }
                    if ($cort == 'cell' || strpos($tablecorner, 'R') !== false) {
                        if ($Tw > $Rw) $xadj2 = ($Tw - $Rw) / 2;
                        if ($Tw < $Rw) $xadj2 = ($Tw + $Rw) / 2;
                    } else {
                        $xadj2 = $Tw / 2 - $bsh / 2;
                    }
                    if (!$bSeparate && $details['mbw']['TL']) {
                        $xadj = ($Tw - $details['mbw']['TL']) / 2;
                    }
                    if (!$bSeparate && $details['mbw']['TR']) {
                        $xadj2 = ($Tw - $details['mbw']['TR']) / 2;
                    }
                    $print = true;
                }
                if ($Lw && $side == 'L' && $this->issetBorder($bord, _BORDER_LEFT)) {    // LEFT
                    $ly1 = $y;
                    $ly2 = $y2;
                    $lx1 = $x;
                    $lx2 = $x;
                    $this->SetLineWidth($Lw);
                    if ($cort == 'cell' || strpos($tablecorner, 'T') !== false) {
                        if ($Lw > $Tw) $yadj = ($Lw - $Tw) / 2;
                        if ($Lw < $Tw) $yadj = ($Lw + $Tw) / 2;
                    } else {
                        $yadj = $Lw / 2 - $bsv / 2;
                    }
                    if ($cort == 'cell' || strpos($tablecorner, 'B') !== false) {
                        if ($Lw > $Bw) $yadj2 = ($Lw - $Bw) / 2;
                        if ($Lw < $Bw) $yadj2 = ($Lw + $Bw) / 2;
                    } else {
                        $yadj2 = $Lw / 2 - $bsv / 2;
                    }
                    if (!$bSeparate && $details['mbw']['LT']) {
                        $yadj = ($Lw - $details['mbw']['LT']) / 2;
                    }
                    if (!$bSeparate && $details['mbw']['LB']) {
                        $yadj2 = ($Lw - $details['mbw']['LB']) / 2;
                    }
                    $print = true;
                }
                if ($Rw && $side == 'R' && $this->issetBorder($bord, _BORDER_RIGHT)) {    // RIGHT
                    $ly1 = $y;
                    $ly2 = $y2;
                    $lx1 = $x2;
                    $lx2 = $x2;
                    $this->SetLineWidth($Rw);
                    if ($cort == 'cell' || strpos($tablecorner, 'T') !== false) {
                        if ($Rw < $Tw) $yadj = ($Rw + $Tw) / 2;
                        if ($Rw > $Tw) $yadj = ($Rw - $Tw) / 2;
                    } else {
                        $yadj = $Rw / 2 - $bsv / 2;
                    }

                    if ($cort == 'cell' || strpos($tablecorner, 'B') !== false) {
                        if ($Rw > $Bw) $yadj2 = ($Rw - $Bw) / 2;
                        if ($Rw < $Bw) $yadj2 = ($Rw + $Bw) / 2;
                    } else {
                        $yadj2 = $Rw / 2 - $bsv / 2;
                    }

                    if (!$bSeparate && $details['mbw']['RT']) {
                        $yadj = ($Rw - $details['mbw']['RT']) / 2;
                    }
                    if (!$bSeparate && $details['mbw']['RB']) {
                        $yadj2 = ($Rw - $details['mbw']['RB']) / 2;
                    }
                    $print = true;
                }
                if ($Bw && $side == 'B' && $this->issetBorder($bord, _BORDER_BOTTOM)) {    // BOTTOM
                    $ly1 = $y2;
                    $ly2 = $y2;
                    $lx1 = $x;
                    $lx2 = $x2;
                    $this->SetLineWidth($Bw);
                    if ($cort == 'cell' || strpos($tablecorner, 'L') !== false) {
                        if ($Bw > $Lw) $xadj = ($Bw - $Lw) / 2;
                        if ($Bw < $Lw) $xadj = ($Bw + $Lw) / 2;
                    } else {
                        $xadj = $Bw / 2 - $bsh / 2;
                    }
                    if ($cort == 'cell' || strpos($tablecorner, 'R') !== false) {
                        if ($Bw > $Rw) $xadj2 = ($Bw - $Rw) / 2;
                        if ($Bw < $Rw) $xadj2 = ($Bw + $Rw) / 2;
                    } else {
                        $xadj2 = $Bw / 2 - $bsh / 2;
                    }
                    if (!$bSeparate && $details['mbw']['BL']) {
                        $xadj = ($Bw - $details['mbw']['BL']) / 2;
                    }
                    if (!$bSeparate && $details['mbw']['BR']) {
                        $xadj2 = ($Bw - $details['mbw']['BR']) / 2;
                    }
                    $print = true;
                }

                // Now draw line
                if ($print) {
                    /*-- TABLES-ADVANCED-BORDERS --*/
                    if ($details[$side]['style'] == 'double') {
                        if (!isset($details[$side]['overlay']) || !$details[$side]['overlay'] || $bSeparate) {
                            if ($details[$side]['c']) {
                                $this->SetDColor($details[$side]['c']);
                            } else {
                                $this->SetDColor($this->ConvertColor(0));
                            }
                            $this->Line($lx1 + $xadj, $ly1 + $yadj, $lx2 - $xadj2, $ly2 - $yadj2);
                        }
                        if ((isset($details[$side]['overlay']) && $details[$side]['overlay']) || $bSeparate) {
                            if ($bSeparate && $cort == 'table') {
                                if ($side == 'T') {
                                    $xadj -= $this->LineWidth / 2;
                                    $xadj2 -= $this->LineWidth;
                                    if ($this->issetBorder($bord, _BORDER_LEFT)) {
                                        $xadj += $this->LineWidth / 2;
                                    }
                                    if ($this->issetBorder($bord, _BORDER_RIGHT)) {
                                        $xadj2 += $this->LineWidth;
                                    }
                                }
                                if ($side == 'L') {
                                    $yadj -= $this->LineWidth / 2;
                                    $yadj2 -= $this->LineWidth;
                                    if ($this->issetBorder($bord, _BORDER_TOP)) {
                                        $yadj += $this->LineWidth / 2;
                                    }
                                    if ($this->issetBorder($bord, _BORDER_BOTTOM)) {
                                        $yadj2 += $this->LineWidth;
                                    }
                                }
                                if ($side == 'B') {
                                    $xadj -= $this->LineWidth / 2;
                                    $xadj2 -= $this->LineWidth;
                                    if ($this->issetBorder($bord, _BORDER_LEFT)) {
                                        $xadj += $this->LineWidth / 2;
                                    }
                                    if ($this->issetBorder($bord, _BORDER_RIGHT)) {
                                        $xadj2 += $this->LineWidth;
                                    }
                                }
                                if ($side == 'R') {
                                    $yadj -= $this->LineWidth / 2;
                                    $yadj2 -= $this->LineWidth;
                                    if ($this->issetBorder($bord, _BORDER_TOP)) {
                                        $yadj += $this->LineWidth / 2;
                                    }
                                    if ($this->issetBorder($bord, _BORDER_BOTTOM)) {
                                        $yadj2 += $this->LineWidth;
                                    }
                                }
                            }

                            $this->SetLineWidth($this->LineWidth / 3);

                            $tbcol = $this->ConvertColor(255);
                            for ($l = 0; $l <= $this->blklvl; $l++) {
                                if ($this->blk[$l]['bgcolor']) {
                                    $tbcol = ($this->blk[$l]['bgcolorarray']);    // mPDF 5.6.53
                                }
                            }

                            if ($bSeparate) {
                                $cellBorderOverlay[] = array(
                                    'x' => $lx1 + $xadj,
                                    'y' => $ly1 + $yadj,
                                    'x2' => $lx2 - $xadj2,
                                    'y2' => $ly2 - $yadj2,
                                    'col' => $tbcol,
                                    'lw' => $this->LineWidth,
                                );
                            } else {
                                $this->SetDColor($tbcol);
                                $this->Line($lx1 + $xadj, $ly1 + $yadj, $lx2 - $xadj2, $ly2 - $yadj2);
                            }
                        }
                    } else if (isset($details[$side]['style']) && ($details[$side]['style'] == 'ridge' || $details[$side]['style'] == 'groove' || $details[$side]['style'] == 'inset' || $details[$side]['style'] == 'outset')) {
                        if (!isset($details[$side]['overlay']) || !$details[$side]['overlay'] || $bSeparate) {
                            if ($details[$side]['c']) {
                                $this->SetDColor($details[$side]['c']);
                            } else {
                                $this->SetDColor($this->ConvertColor(0));
                            }
                            if ($details[$side]['style'] == 'outset' || $details[$side]['style'] == 'groove') {
                                $nc = $this->_darkenColor($details[$side]['c']);
                                $this->SetDColor($nc);
                            } else if ($details[$side]['style'] == 'ridge' || $details[$side]['style'] == 'inset') {
                                $nc = $this->_lightenColor($details[$side]['c']);
                                $this->SetDColor($nc);
                            }
                            $this->Line($lx1 + $xadj, $ly1 + $yadj, $lx2 - $xadj2, $ly2 - $yadj2);
                        }
                        if ((isset($details[$side]['overlay']) && $details[$side]['overlay']) || $bSeparate) {
                            if ($details[$side]['c']) {
                                $this->SetDColor($details[$side]['c']);
                            } else {
                                $this->SetDColor($this->ConvertColor(0));
                            }
                            $doubleadj = ($this->LineWidth) / 3;
                            $this->SetLineWidth($this->LineWidth / 2);
                            $xadj3 = $yadj3 = $wadj3 = $hadj3 = 0;

                            if ($details[$side]['style'] == 'ridge' || $details[$side]['style'] == 'inset') {
                                $nc = $this->_darkenColor($details[$side]['c']);

                                if ($bSeparate && $cort == 'table') {
                                    if ($side == 'T') {
                                        $yadj3 = $this->LineWidth / 2;
                                        $xadj3 = -$this->LineWidth / 2;
                                        $wadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_LEFT)) {
                                            $xadj3 += $this->LineWidth;
                                            $wadj3 -= $this->LineWidth;
                                        }
                                        if ($this->issetBorder($bord, _BORDER_RIGHT)) {
                                            $wadj3 -= $this->LineWidth * 2;
                                        }
                                    }
                                    if ($side == 'L') {
                                        $xadj3 = $this->LineWidth / 2;
                                        $yadj3 = -$this->LineWidth / 2;
                                        $hadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_TOP)) {
                                            $yadj3 += $this->LineWidth;
                                            $hadj3 -= $this->LineWidth;
                                        }
                                        if ($this->issetBorder($bord, _BORDER_BOTTOM)) {
                                            $hadj3 -= $this->LineWidth * 2;
                                        }
                                    }
                                    if ($side == 'B') {
                                        $yadj3 = $this->LineWidth / 2;
                                        $xadj3 = -$this->LineWidth / 2;
                                        $wadj3 = $this->LineWidth;
                                    }
                                    if ($side == 'R') {
                                        $xadj3 = $this->LineWidth / 2;
                                        $yadj3 = -$this->LineWidth / 2;
                                        $hadj3 = $this->LineWidth;
                                    }
                                } else if ($side == 'T') {
                                    $yadj3 = $this->LineWidth / 2;
                                    $xadj3 = $this->LineWidth / 2;
                                    $wadj3 = -$this->LineWidth * 2;
                                } else if ($side == 'L') {
                                    $xadj3 = $this->LineWidth / 2;
                                    $yadj3 = $this->LineWidth / 2;
                                    $hadj3 = -$this->LineWidth * 2;
                                } else if ($side == 'B' && $bSeparate) {
                                    $yadj3 = $this->LineWidth / 2;
                                    $wadj3 = $this->LineWidth / 2;
                                } else if ($side == 'R' && $bSeparate) {
                                    $xadj3 = $this->LineWidth / 2;
                                    $hadj3 = $this->LineWidth / 2;
                                } else if ($side == 'B') {
                                    $yadj3 = $this->LineWidth / 2;
                                    $xadj3 = $this->LineWidth / 2;
                                } else if ($side == 'R') {
                                    $xadj3 = $this->LineWidth / 2;
                                    $yadj3 = $this->LineWidth / 2;
                                }
                            } else {
                                $nc = $this->_lightenColor($details[$side]['c']);

                                if ($bSeparate && $cort == 'table') {
                                    if ($side == 'T') {
                                        $yadj3 = $this->LineWidth / 2;
                                        $xadj3 = -$this->LineWidth / 2;
                                        $wadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_LEFT)) {
                                            $xadj3 += $this->LineWidth;
                                            $wadj3 -= $this->LineWidth;
                                        }
                                    }
                                    if ($side == 'L') {
                                        $xadj3 = $this->LineWidth / 2;
                                        $yadj3 = -$this->LineWidth / 2;
                                        $hadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_TOP)) {
                                            $yadj3 += $this->LineWidth;
                                            $hadj3 -= $this->LineWidth;
                                        }
                                    }
                                    if ($side == 'B') {
                                        $yadj3 = $this->LineWidth / 2;
                                        $xadj3 = -$this->LineWidth / 2;
                                        $wadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_LEFT)) {
                                            $xadj3 += $this->LineWidth;
                                            $wadj3 -= $this->LineWidth;
                                        }
                                    }
                                    if ($side == 'R') {
                                        $xadj3 = $this->LineWidth / 2;
                                        $yadj3 = -$this->LineWidth / 2;
                                        $hadj3 = $this->LineWidth;
                                        if ($this->issetBorder($bord, _BORDER_TOP)) {
                                            $yadj3 += $this->LineWidth;
                                            $hadj3 -= $this->LineWidth;
                                        }
                                    }
                                } else if ($side == 'T') {
                                    $yadj3 = $this->LineWidth / 2;
                                    $xadj3 = $this->LineWidth / 2;
                                } else if ($side == 'L') {
                                    $xadj3 = $this->LineWidth / 2;
                                    $yadj3 = $this->LineWidth / 2;
                                } else if ($side == 'B' && $bSeparate) {
                                    $yadj3 = $this->LineWidth / 2;
                                    $xadj3 = $this->LineWidth / 2;
                                } else if ($side == 'R' && $bSeparate) {
                                    $xadj3 = $this->LineWidth / 2;
                                    $yadj3 = $this->LineWidth / 2;
                                } else if ($side == 'B') {
                                    $yadj3 = $this->LineWidth / 2;
                                    $xadj3 = -$this->LineWidth / 2;
                                    $wadj3 = $this->LineWidth;
                                } else if ($side == 'R') {
                                    $xadj3 = $this->LineWidth / 2;
                                    $yadj3 = -$this->LineWidth / 2;
                                    $hadj3 = $this->LineWidth;
                                }

                            }

                            if ($bSeparate) {
                                $cellBorderOverlay[] = array(
                                    'x' => $lx1 + $xadj + $xadj3,
                                    'y' => $ly1 + $yadj + $yadj3,
                                    'x2' => $lx2 - $xadj2 + $xadj3 + $wadj3,
                                    'y2' => $ly2 - $yadj2 + $yadj3 + $hadj3,
                                    'col' => $nc,
                                    'lw' => $this->LineWidth,
                                );
                            } else {
                                $this->SetDColor($nc);
                                $this->Line($lx1 + $xadj + $xadj3, $ly1 + $yadj + $yadj3, $lx2 - $xadj2 + $xadj3 + $wadj3, $ly2 - $yadj2 + $yadj3 + $hadj3);
                            }
                        }
                    } else {
                        /*-- END TABLES-ADVANCED-BORDERS --*/
                        if ($details[$side]['style'] == 'dashed') {
                            $dashsize = 2;    // final dash will be this + 1*linewidth
                            $dashsizek = 1.5;    // ratio of Dash/Blank
                            $this->SetDash($dashsize, ($dashsize / $dashsizek) + ($this->LineWidth * 2));
                        } else if ($details[$side]['style'] == 'dotted') {
                            $this->SetLineJoin(1);
                            $this->SetLineCap(1);
                            $this->SetDash(0.001, ($this->LineWidth * 2));
                        }
                        if ($details[$side]['c']) {
                            $this->SetDColor($details[$side]['c']);
                        } else {
                            $this->SetDColor($this->ConvertColor(0));
                        }
                        $this->Line($lx1 + $xadj, $ly1 + $yadj, $lx2 - $xadj2, $ly2 - $yadj2);
                        /*-- TABLES-ADVANCED-BORDERS --*/
                    }
                    /*-- END TABLES-ADVANCED-BORDERS --*/

                    // Reset Corners
                    $this->SetDash();
                    //BUTT style line cap
                    $this->SetLineCap(2);
                }
            }

            if ($bSeparate && count($cellBorderOverlay)) {
                foreach ($cellBorderOverlay AS $cbo) {
                    $this->SetLineWidth($cbo['lw']);
                    $this->SetDColor($cbo['col']);
                    $this->Line($cbo['x'], $cbo['y'], $cbo['x2'], $cbo['y2']);
                }
            }

            // $this->SetLineWidth($oldlinewidth);
            // $this->SetDColor($this->ConvertColor(0));
        }
    }

    function Rect($x, $y, $w, $h, $style = '')
    {
        //Draw a rectangle
        if ($style == 'F') $op = 'f';
        elseif ($style == 'FD' or $style == 'DF') $op = 'B';
        else $op = 'S';
        $this->_out(sprintf('%.3F %.3F %.3F %.3F re %s', $x * _MPDFK, ($this->h - $y) * _MPDFK, $w * _MPDFK, -$h * _MPDFK, $op));
    }

// WORD SPACING

    function SetLineWidth($width)
    {
        //Set line width
        $this->LineWidth = $width;
        $lwout = (sprintf('%.3F w', $width * _MPDFK));
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineWidth']) && $this->pageoutput[$this->page]['LineWidth'] != $lwout) || !isset($this->pageoutput[$this->page]['LineWidth']) || $this->keep_block_together)) {
            $this->_out($lwout);
        }
        $this->pageoutput[$this->page]['LineWidth'] = $lwout;
    }

    function SetLineJoin($mode = 0)
    {
        $s = sprintf('%d j', $mode);
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineJoin']) && $this->pageoutput[$this->page]['LineJoin'] != $s) || !isset($this->pageoutput[$this->page]['LineJoin']) || $this->keep_block_together)) {
            $this->_out($s);
        }
        $this->pageoutput[$this->page]['LineJoin'] = $s;

    }

    function issetBorder($var, $flag)
    {
        $flag = intval($flag);
        $var = intval($var);
        return (($var & $flag) == $flag);
    }

    function Line($x1, $y1, $x2, $y2)
    {
        //Draw a line
        $this->_out(sprintf('%.3F %.3F m %.3F %.3F l S', $x1 * _MPDFK, ($this->h - $y1) * _MPDFK, $x2 * _MPDFK, ($this->h - $y2) * _MPDFK));
    }

    function _darkenColor($c)
    {
        if (is_array($c)) {
            die('Color error in _darkenColor');
        }
        if ($c{0} == 3 || $c{0} == 5) {    // RGB
            list($h, $s, $l) = $this->rgb2hsl(ord($c{1}) / 255, ord($c{2}) / 255, ord($c{3}) / 255);
            $s *= 0.25;
            $l *= 0.75;
            list($r, $g, $b) = $this->hsl2rgb($h, $s, $l);
            $ret = array(3, $r, $g, $b);
        } else if ($c{0} == 4 || $c{0} == 6) {    // CMYK
            $ret = array(4, min(100, (ord($c{1}) + 20)), min(100, (ord($c{2}) + 20)), min(100, (ord($c{3}) + 20)), min(100, (ord($c{4}) + 20)));
        } else if ($c{0} == 1) {    // Grayscale
            $ret = array(1, max(0, (ord($c{1}) - 32)));
        }
        $c = array_pad($ret, 6, 0);
        $cstr = pack("a1ccccc", $c[0], ($c[1] & 0xFF), ($c[2] & 0xFF), ($c[3] & 0xFF), ($c[4] & 0xFF), ($c[5] & 0xFF));
        return $cstr;
    }


    /*-- DIRECTW --*/

    function rgb2hsl($var_r, $var_g, $var_b)
    {
        $var_min = min($var_r, $var_g, $var_b);
        $var_max = max($var_r, $var_g, $var_b);
        $del_max = $var_max - $var_min;
        $l = ($var_max + $var_min) / 2;
        if ($del_max == 0) {
            $h = 0;
            $s = 0;
        } else {
            if ($l < 0.5) {
                $s = $del_max / ($var_max + $var_min);
            } else {
                $s = $del_max / (2 - $var_max - $var_min);
            }
            $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
            $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
            $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;
            if ($var_r == $var_max) {
                $h = $del_b - $del_g;
            } elseif ($var_g == $var_max) {
                $h = (1 / 3) + $del_r - $del_b;
            } elseif ($var_b == $var_max) {
                $h = (2 / 3) + $del_g - $del_r;
            };
            if ($h < 0) {
                $h += 1;
            }
            if ($h > 1) {
                $h -= 1;
            }
        }
        return array($h, $s, $l);
    }
    /*-- END DIRECTW --*/


    /*-- HTML-CSS --*/

    function _lightenColor($c)
    {
        if (is_array($c)) {
            die('Color error in _lightencolor');
        }
        if ($c{0} == 3 || $c{0} == 5) {    // RGB
            list($h, $s, $l) = $this->rgb2hsl(ord($c{1}) / 255, ord($c{2}) / 255, ord($c{3}) / 255);
            $l += ((1 - $l) * 0.8);
            list($r, $g, $b) = $this->hsl2rgb($h, $s, $l);
            $ret = array(3, $r, $g, $b);
        } else if ($c{0} == 4 || $c{0} == 6) {    // CMYK
            $ret = array(4, max(0, (ord($c{1}) - 20)), max(0, (ord($c{2}) - 20)), max(0, (ord($c{3}) - 20)), max(0, (ord($c{4}) - 20)));
        } else if ($c{0} == 1) {    // Grayscale
            $ret = array(1, min(255, (ord($c{1}) + 32)));
        }
        $c = array_pad($ret, 6, 0);
        $cstr = pack("a1ccccc", $c[0], ($c[1] & 0xFF), ($c[2] & 0xFF), ($c[3] & 0xFF), ($c[4] & 0xFF), ($c[5] & 0xFF));
        return $cstr;
    }

    function SetDash($black = false, $white = false)
    {
        if ($black and $white) $s = sprintf('[%.3F %.3F] 0 d', $black * _MPDFK, $white * _MPDFK);
        else $s = '[] 0 d';
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Dash']) && $this->pageoutput[$this->page]['Dash'] != $s) || !isset($this->pageoutput[$this->page]['Dash']) || $this->keep_block_together)) {
            $this->_out($s);
        }
        $this->pageoutput[$this->page]['Dash'] = $s;

    }


// Used when ColActive for tables - updated to return first block with background fill OR borders

    function SetLineCap($mode = 2)
    {
        $s = sprintf('%d J', $mode);
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineCap']) && $this->pageoutput[$this->page]['LineCap'] != $s) || !isset($this->pageoutput[$this->page]['LineCap']) || $this->keep_block_together)) {
            $this->_out($s);
        }
        $this->pageoutput[$this->page]['LineCap'] = $s;

    }

    function SetCol($CurrCol)
    {
// Used internally to set column by number: 0 is 1st column
        //Set position on a column
        $this->CurrCol = $CurrCol;
        $x = $this->ColL[$CurrCol];
        $xR = $this->ColR[$CurrCol];    // NB This is not R margin -> R pos
        if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {    // EVEN
            $x += $this->MarginCorrection;
            $xR += $this->MarginCorrection;
        }
        $this->SetMargins($x, ($this->w - $xR), $this->tMargin);
    }


//-------------------------FLOWING BLOCK------------------------------------//
//The following functions were originally written by Damon Kohler           //
//--------------------------------------------------------------------------//

    function printcolumnbuffer()
    {
        // Columns ended (but page not ended) -> try to match all columns - unless disabled by using a custom column-break
        if (!$this->ColActive && $this->ColumnAdjust && !$this->keepColumns) {    // mPDF 5.7.2
            // Calculate adjustment to add to each column to calculate rel_y value
            $this->ColDetails[0]['add_y'] = 0;
            $last_col = 0;
            // Recursively add previous column's height
            for ($i = 1; $i < $this->NbCol; $i++) {
                if (isset($this->ColDetails[$i]['bottom_margin']) && $this->ColDetails[$i]['bottom_margin']) { // If any entries in the column
                    $this->ColDetails[$i]['add_y'] = ($this->ColDetails[$i - 1]['bottom_margin'] - $this->y0) + $this->ColDetails[$i - 1]['add_y'];
                    $last_col = $i;    // Last column actually printed
                }
            }

            // Calculate value for each position sensitive entry as though for one column
            foreach ($this->columnbuffer AS $key => $s) {
                $t = $s['s'];
                if ($t == 'ACROFORM') {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                    $this->columnbuffer[$key]['s'] = '';
                } else if (preg_match('/BT \d+\.\d\d+ (\d+\.\d\d+) Td/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                } else if (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ [\-]{0,1}\d+\.\d\d+ re/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                } else if (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) m/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                } else if (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) l/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                } else if (preg_match('/q \d+\.\d\d+ 0 0 \d+\.\d\d+ \d+\.\d\d+ (\d+\.\d\d+) cm \/(I|FO)\d+ Do Q/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                } else if (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ c/', $t)) {
                    $this->columnbuffer[$key]['rel_y'] = $s['y'] + $this->ColDetails[$s['col']]['add_y'] - $this->y0;
                }
            }
            foreach ($this->internallink AS $key => $f) {
                if (is_array($f) && isset($f['col'])) {
                    $this->internallink[$key]['rel_y'] = $f['Y'] + $this->ColDetails[$f['col']]['add_y'] - $this->y0;
                }
            }

            $breaks = array();
            foreach ($this->breakpoints AS $c => $bpa) {
                foreach ($bpa AS $rely) {
                    $breaks[] = $rely + $this->ColDetails[$c]['add_y'] - $this->y0;
                }
            }

            if (isset($this->ColDetails[$last_col]['bottom_margin'])) {
                $lcbm = $this->ColDetails[$last_col]['bottom_margin'];
            } else {
                $lcbm = 0;
            }
            $sum_h = $this->ColDetails[$last_col]['add_y'] + $lcbm - $this->y0;
            //$sum_h = max($this->ColDetails[$last_col]['add_y'] + $this->ColDetails[$last_col]['bottom_margin'] - $this->y0, end($breaks));
            $target_h = ($sum_h / $this->NbCol);

            $cbr = array();
            for ($i = 1; $i < $this->NbCol; $i++) {
                $th = ($sum_h * $i / $this->NbCol);
                foreach ($breaks AS $bk => $val) {
                    if ($val > $th) {
                        if (($val - $th) < ($th - $breaks[$bk - 1])) {
                            $cbr[$i - 1] = $val;
                        } else {
                            $cbr[$i - 1] = $breaks[$bk - 1];
                        }
                        break;
                    }
                }
            }
            $cbr[($this->NbCol - 1)] = $sum_h;

            // Now update the columns - divide into columns of approximately equal value
            $last_new_col = 0;
            $yadj = 0;    // mm
            $xadj = 0;
            $last_col_bottom = 0;
            $lowest_bottom_y = 0;
            $block_bottom = 0;
            $newcolumn = 0;
            foreach ($this->columnbuffer AS $key => $s) {
                if (isset($s['rel_y'])) {    // only process position sensitive data
                    if ($s['rel_y'] >= $cbr[$newcolumn]) {
                        $newcolumn++;
                    } else {
                        $newcolumn = $last_new_col;
                    }


                    $block_bottom = max($block_bottom, ($s['rel_y'] + $s['h']));

                    if ($this->directionality == 'rtl') {    // *RTL*
                        $xadj = -(($newcolumn - $s['col']) * ($this->ColWidth + $this->ColGap));    // *RTL*
                    }    // *RTL*
                    else {    // *RTL*
                        $xadj = ($newcolumn - $s['col']) * ($this->ColWidth + $this->ColGap);
                    }    // *RTL*

                    if ($last_new_col != $newcolumn) {    // Added new column
                        $last_col_bottom = $this->columnbuffer[$key]['rel_y'];
                        $block_bottom = 0;
                    }
                    $yadj = ($s['rel_y'] - $s['y']) - ($last_col_bottom) + $this->y0;
                    // callback function
                    $t = $s['s'];

                    // mPDF 5.7+
                    $t = $this->columnAdjustPregReplace('Td', $xadj, $yadj, '/BT (\d+\.\d\d+) (\d+\.\d\d+) Td/', $t);
                    $t = $this->columnAdjustPregReplace('re', $xadj, $yadj, '/(\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) ([\-]{0,1}\d+\.\d\d+) re/', $t);
                    $t = $this->columnAdjustPregReplace('l', $xadj, $yadj, '/(\d+\.\d\d+) (\d+\.\d\d+) l/', $t);
                    $t = $this->columnAdjustPregReplace('img', $xadj, $yadj, '/q (\d+\.\d\d+) 0 0 (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) cm \/(I|FO)/', $t);
                    $t = $this->columnAdjustPregReplace('draw', $xadj, $yadj, '/(\d+\.\d\d+) (\d+\.\d\d+) m/', $t);
                    $t = $this->columnAdjustPregReplace('bezier', $xadj, $yadj, '/(\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) (\d+\.\d\d+) c/', $t);

                    $this->columnbuffer[$key]['s'] = $t;
                    $this->columnbuffer[$key]['newcol'] = $newcolumn;
                    $this->columnbuffer[$key]['newy'] = $s['y'] + $yadj;
                    $last_new_col = $newcolumn;
                    $clb = $s['y'] + $yadj + $s['h'];    // bottom_margin of current
                    if ((isset($this->ColDetails[$newcolumn]['max_bottom']) && $clb > $this->ColDetails[$newcolumn]['max_bottom']) || (!isset($this->ColDetails[$newcolumn]['max_bottom']) && $clb)) {
                        $this->ColDetails[$newcolumn]['max_bottom'] = $clb;
                    }
                    if ($clb > $lowest_bottom_y) {
                        $lowest_bottom_y = $clb;
                    }
                    // Adjust LINKS
                    if (isset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                        $ref = $this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                        $this->PageLinks[$this->page][$ref][0] += ($xadj * _MPDFK);
                        $this->PageLinks[$this->page][$ref][1] -= ($yadj * _MPDFK);
                        unset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                    }
                    // Adjust FORM FIELDS
                    if (isset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                        $ref = $this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                        $this->form->forms[$ref]['x'] += ($xadj);
                        $this->form->forms[$ref]['y'] += ($yadj);
                        unset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                    }
                    /*-- ANNOTATIONS --*/
                    if (isset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                        $ref = $this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                        if ($this->PageAnnots[$this->page][$ref]['x'] < 0) {
                            $this->PageAnnots[$this->page][$ref]['x'] -= ($xadj);
                        } else {
                            $this->PageAnnots[$this->page][$ref]['x'] += ($xadj);
                        }
                        $this->PageAnnots[$this->page][$ref]['y'] += ($yadj);    // unlike PageLinks, Page annots has y values from top in mm
                        unset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                    }
                    /*-- END ANNOTATIONS --*/
                }
            }

            /*-- BOOKMARKS --*/
            // Adjust Bookmarks
            foreach ($this->col_BMoutlines AS $v) {
                $this->BMoutlines[] = array('t' => $v['t'], 'l' => $v['l'], 'y' => $this->y0, 'p' => $v['p']);
            }
            /*-- END BOOKMARKS --*/

            /*-- INDEX --*/
            // Adjust Reference (index)
            foreach ($this->col_Reference AS $v) {
                $Present = 0;
                //Search the reference (AND Ref/PageNo) in the array
                for ($i = 0; $i < count($this->Reference); $i++) {
                    if ($this->Reference[$i]['t'] == $v['t']) {
                        $Present = 1;
                        if (!in_array($v['op'], $this->Reference[$i]['p'])) {
                            $this->Reference[$i]['p'][] = $v['op'];
                        }
                    }
                }
                if ($Present == 0) {
                    $this->Reference[] = array('t' => $v['t'], 'p' => array($v['op']));
                }
            }
            /*-- END INDEX --*/

            /*-- TOC --*/

            // Adjust ToC
            foreach ($this->col_toc AS $v) {
                $this->tocontents->_toc[] = array('t' => $v['t'], 'l' => $v['l'], 'p' => $v['p'], 'link' => $v['link'], 'toc_id' => $v['toc_id']);
                $this->links[$v['link']][1] = $this->y0;
            }
            /*-- END TOC --*/

            // Adjust column length to be equal
            if ($this->colvAlign == 'J') {
                foreach ($this->columnbuffer AS $key => $s) {
                    if (isset($s['rel_y'])) {    // only process position sensitive data
                        // Set ratio to expand y values or heights
                        if (isset($this->ColDetails[$s['newcol']]['max_bottom']) && $this->ColDetails[$s['newcol']]['max_bottom'] && $this->ColDetails[$s['newcol']]['max_bottom'] != $this->y0) {
                            $ratio = ($lowest_bottom_y - ($this->y0)) / ($this->ColDetails[$s['newcol']]['max_bottom'] - ($this->y0));
                        } else {
                            $ratio = 1;
                        }
                        if (($ratio > 1) && ($ratio <= $this->max_colH_correction)) {
                            $yadj = ($s['newy'] - $this->y0) * ($ratio - 1);

                            // Adjust LINKS
                            if (isset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                                $ref = $this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                                $this->PageLinks[$this->page][$ref][1] -= ($yadj * _MPDFK);    // y value
                                $this->PageLinks[$this->page][$ref][3] *= $ratio;    // height
                                unset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                            }
                            // Adjust FORM FIELDS
                            if (isset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                                $ref = $this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                                $this->form->forms[$ref]['x'] += ($xadj);
                                $this->form->forms[$ref]['y'] += ($yadj);
                                unset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                            }
                            /*-- ANNOTATIONS --*/
                            if (isset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                                $ref = $this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                                $this->PageAnnots[$this->page][$ref]['y'] += ($yadj);
                                unset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                            }
                            /*-- END ANNOTATIONS --*/
                        }
                    }
                }
                foreach ($this->internallink AS $key => $f) {
                    if (is_array($f) && isset($f['col'])) {
                        $last_col_bottom = 0;
                        for ($nbc = 0; $nbc < $this->NbCol; $nbc++) {
                            if ($f['rel_y'] >= $cbr[$nbc]) {
                                $last_col_bottom = $cbr[$nbc];
                            }
                        }
                        $yadj = ($f['rel_y'] - $f['Y']) - $last_col_bottom + $this->y0;
                        $f['Y'] += $yadj;
                        unset($f['col']);
                        unset($f['rel_y']);
                        $this->internallink[$key] = $f;
                    }
                }

                $last_col = -1;
                $trans_on = false;
                foreach ($this->columnbuffer AS $key => $s) {
                    if (isset($s['rel_y'])) {    // only process position sensitive data
                        // Set ratio to expand y values or heights
                        if (isset($this->ColDetails[$s['newcol']]['max_bottom']) && $this->ColDetails[$s['newcol']]['max_bottom'] && $this->ColDetails[$s['newcol']]['max_bottom'] != $this->y0) {
                            $ratio = ($lowest_bottom_y - ($this->y0)) / ($this->ColDetails[$s['newcol']]['max_bottom'] - ($this->y0));
                        } else {
                            $ratio = 1;
                        }
                        if (($ratio > 1) && ($ratio <= $this->max_colH_correction)) {
                            //Start Transformation
                            $this->pages[$this->page] .= $this->StartTransform(true) . "\n";
                            $this->pages[$this->page] .= $this->transformScale(100, $ratio * 100, $x = '', $this->y0, true) . "\n";
                            $trans_on = true;
                        }
                    }
                    // Now output the adjusted values
                    $this->pages[$this->page] .= $s['s'] . "\n";
                    if (isset($s['rel_y']) && ($ratio > 1) && ($ratio <= $this->max_colH_correction)) {    // only process position sensitive data
                        //Stop Transformation
                        $this->pages[$this->page] .= $this->StopTransform(true) . "\n";
                        $trans_on = false;
                    }
                }
                if ($trans_on) {
                    $this->pages[$this->page] .= $this->StopTransform(true) . "\n";
                }
            } else {    // if NOT $this->colvAlign == 'J'
                // Now output the adjusted values
                foreach ($this->columnbuffer AS $s) {
                    $this->pages[$this->page] .= $s['s'] . "\n";
                }
            }
            if ($lowest_bottom_y > 0) {
                $this->y = $lowest_bottom_y;
            }
        } // Columns not ended but new page -> align columns (can leave the columns alone - just tidy up the height)
        else if ($this->colvAlign == 'J' && $this->ColumnAdjust && !$this->keepColumns) {
            // calculate the lowest bottom margin
            $lowest_bottom_y = 0;
            foreach ($this->columnbuffer AS $key => $s) {
                // Only process output data
                $t = $s['s'];
                if ($t == 'ACROFORM' || (preg_match('/BT \d+\.\d\d+ (\d+\.\d\d+) Td/', $t)) || (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ [\-]{0,1}\d+\.\d\d+ re/', $t)) ||
                    (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) l/', $t)) ||
                    (preg_match('/q \d+\.\d\d+ 0 0 \d+\.\d\d+ \d+\.\d\d+ (\d+\.\d\d+) cm \/(I|FO)\d+ Do Q/', $t)) ||
                    (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) m/', $t)) ||
                    (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ c/', $t))) {

                    $clb = $s['y'] + $s['h'];
                    if ((isset($this->ColDetails[$s['col']]['max_bottom']) && $clb > $this->ColDetails[$s['col']]['max_bottom']) || !isset($this->ColDetails[$s['col']]['max_bottom'])) {
                        $this->ColDetails[$s['col']]['max_bottom'] = $clb;
                    }
                    if ($clb > $lowest_bottom_y) {
                        $lowest_bottom_y = $clb;
                    }
                    $this->columnbuffer[$key]['rel_y'] = $s['y'];    // Marks position sensitive data to process later
                    if ($t == 'ACROFORM') {
                        $this->columnbuffer[$key]['s'] = '';
                    }
                }
            }
            // Adjust column length equal
            foreach ($this->columnbuffer AS $key => $s) {
                // Set ratio to expand y values or heights
                if (isset($this->ColDetails[$s['col']]['max_bottom']) && $this->ColDetails[$s['col']]['max_bottom']) {
                    $ratio = ($lowest_bottom_y - ($this->y0)) / ($this->ColDetails[$s['col']]['max_bottom'] - ($this->y0));
                } else {
                    $ratio = 1;
                }
                if (($ratio > 1) && ($ratio <= $this->max_colH_correction)) {
                    $yadj = ($s['y'] - $this->y0) * ($ratio - 1);

                    // Adjust LINKS
                    if (isset($s['rel_y'])) {    // only process position sensitive data
                        // otherwise triggers for all entries in column buffer (.e.g. formatting) and makes below adjustments more than once
                        if (isset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                            $ref = $this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                            $this->PageLinks[$this->page][$ref][1] -= ($yadj * _MPDFK);    // y value
                            $this->PageLinks[$this->page][$ref][3] *= $ratio;    // height
                            unset($this->columnLinks[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                        }
                        // Adjust FORM FIELDS
                        if (isset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                            $ref = $this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                            $this->form->forms[$ref]['x'] += ($xadj);
                            $this->form->forms[$ref]['y'] += ($yadj);
                            unset($this->columnForms[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                        }
                        /*-- ANNOTATIONS --*/
                        if (isset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])])) {
                            $ref = $this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])];
                            $this->PageAnnots[$this->page][$ref]['y'] += ($yadj);
                            unset($this->columnAnnots[$s['col']][INTVAL($s['x'])][INTVAL($s['y'])]);
                        }
                        /*-- END ANNOTATIONS --*/
                    }
                }
            }

            /*-- BOOKMARKS --*/

            // Adjust Bookmarks
            foreach ($this->col_BMoutlines AS $v) {
                $this->BMoutlines[] = array('t' => $v['t'], 'l' => $v['l'], 'y' => $this->y0, 'p' => $v['p']);
            }
            /*-- END BOOKMARKS --*/

            /*-- INDEX --*/

            // Adjust Reference (index)
            foreach ($this->col_Reference AS $v) {
                $Present = 0;
                //Search the reference (AND Ref/PageNo) in the array
                for ($i = 0; $i < count($this->Reference); $i++) {
                    if ($this->Reference[$i]['t'] == $v['t']) {
                        $Present = 1;
                        if (!in_array($v['op'], $this->Reference[$i]['p'])) {
                            $this->Reference[$i]['p'][] = $v['op'];
                        }
                    }
                }
                if ($Present == 0) {
                    $this->Reference[] = array('t' => $v['t'], 'p' => array($v['op']));
                }
            }
            /*-- END INDEX --*/

            /*-- TOC --*/

            // Adjust ToC
            foreach ($this->col_toc AS $v) {
                $this->tocontents->_toc[] = array('t' => $v['t'], 'l' => $v['l'], 'p' => $v['p'], 'link' => $v['link'], 'toc_id' => $v['toc_id']);
                $this->links[$v['link']][1] = $this->y0;
            }
            /*-- END TOC --*/
            $trans_on = false;
            foreach ($this->columnbuffer AS $key => $s) {
                if (isset($s['rel_y'])) {    // only process position sensitive data
                    // Set ratio to expand y values or heights
                    if ($this->ColDetails[$s['col']]['max_bottom']) {
                        $ratio = ($lowest_bottom_y - ($this->y0)) / ($this->ColDetails[$s['col']]['max_bottom'] - ($this->y0));
                    } else {
                        $ratio = 1;
                    }
                    if (($ratio > 1) && ($ratio <= $this->max_colH_correction)) {
                        //Start Transformation
                        $this->pages[$this->page] .= $this->StartTransform(true) . "\n";
                        $this->pages[$this->page] .= $this->transformScale(100, $ratio * 100, $x = '', $this->y0, true) . "\n";
                        $trans_on = true;
                    }
                }
                // Now output the adjusted values
                $this->pages[$this->page] .= $s['s'] . "\n";
                if (isset($s['rel_y']) && ($ratio > 1) && ($ratio <= $this->max_colH_correction)) {
                    //Stop Transformation
                    $this->pages[$this->page] .= $this->StopTransform(true) . "\n";
                    $trans_on = false;    // mPDF 5.1.001
                }
            }
            if ($trans_on) {
                $this->pages[$this->page] .= $this->StopTransform(true) . "\n";
            }

            if ($lowest_bottom_y > 0) {
                $this->y = $lowest_bottom_y;
            }
        } // Just reproduce the page as it was
        else {
            // If page has not ended but height adjustment was disabled by custom column-break - adjust y
            $lowest_bottom_y = 0;
            if (!$this->ColActive && (!$this->ColumnAdjust || $this->keepColumns)) {
                // calculate the lowest bottom margin
                foreach ($this->columnbuffer AS $key => $s) {
                    // Only process output data
                    $t = $s['s'];
                    if ($t == 'ACROFORM' || (preg_match('/BT \d+\.\d\d+ (\d+\.\d\d+) Td/', $t)) || (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ [\-]{0,1}\d+\.\d\d+ re/', $t)) ||
                        (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) l/', $t)) ||
                        (preg_match('/q \d+\.\d\d+ 0 0 \d+\.\d\d+ \d+\.\d\d+ (\d+\.\d\d+) cm \/(I|FO)\d+ Do Q/', $t)) ||
                        (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) m/', $t)) ||
                        (preg_match('/\d+\.\d\d+ (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ c/', $t))) {

                        $clb = $s['y'] + $s['h'];
                        if ($clb > $this->ColDetails[$s['col']]['max_bottom']) {
                            $this->ColDetails[$s['col']]['max_bottom'] = $clb;
                        }
                        if ($clb > $lowest_bottom_y) {
                            $lowest_bottom_y = $clb;
                        }
                    }
                }
            }
            foreach ($this->columnbuffer AS $key => $s) {
                if ($s['s'] != 'ACROFORM')
                    $this->pages[$this->page] .= $s['s'] . "\n";
            }
            if ($lowest_bottom_y > 0) {
                $this->y = $lowest_bottom_y;
            }
            /*-- INDEX --*/

            // Output Reference (index)
            foreach ($this->col_Reference AS $v) {
                $Present = 0;
                for ($i = 0; $i < count($this->Reference); $i++) {
                    if ($this->Reference[$i]['t'] == $v['t']) {
                        $Present = 1;
                        if (!in_array($v['op'], $this->Reference[$i]['p'])) {
                            $this->Reference[$i]['p'][] = $v['op'];
                        }
                    }
                }
                if ($Present == 0) {
                    $this->Reference[] = array('t' => $v['t'], 'p' => array($v['op']));
                }
            }
            /*-- END INDEX --*/
            /*-- BOOKMARKS --*/
            // Output Bookmarks
            foreach ($this->col_BMoutlines AS $v) {
                $this->BMoutlines[] = array('t' => $v['t'], 'l' => $v['l'], 'y' => $v['y'], 'p' => $v['p']);
            }
            /*-- END BOOKMARKS --*/
            /*-- TOC --*/
            // Output ToC
            foreach ($this->col_toc AS $v) {
                $this->tocontents->_toc[] = array('t' => $v['t'], 'l' => $v['l'], 'p' => $v['p'], 'link' => $v['link'], 'toc_id' => $v['toc_id']);
            }
            /*-- END TOC --*/
        }
        foreach ($this->internallink AS $key => $f) {
            if (isset($this->internallink[$key]['col'])) unset($this->internallink[$key]['col']);
            if (isset($this->internallink[$key]['rel_y'])) unset($this->internallink[$key]['rel_y']);
        }

        $this->columnbuffer = array();
        $this->ColDetails = array();
        $this->columnLinks = array();
        $this->columnAnnots = array();
        $this->columnForms = array();

        $this->col_Reference = array();
        $this->col_BMoutlines = array();
        $this->col_toc = array();
        $this->breakpoints = array();
    }

    function columnAdjustPregReplace($type, $xadj, $yadj, $pattern, $subject)
    {
        preg_match($pattern, $subject, $matches);
        if (!isset($matches[3])) {
            $matches[3] = 0;
        }
        if (!isset($matches[4])) {
            $matches[4] = 0;
        }
        if (!isset($matches[5])) {
            $matches[5] = 0;
        }
        if (!isset($matches[6])) {
            $matches[6] = 0;
        }
        return str_replace($matches[0], $this->columnAdjustAdd($type, _MPDFK, $xadj, $yadj, $matches[1], $matches[2], $matches[3], $matches[4], $matches[5], $matches[6]), $subject);
    }

    function columnAdjustAdd($type, $k, $xadj, $yadj, $a, $b, $c = 0, $d = 0, $e = 0, $f = 0)
    {
        if ($type == 'Td') {    // xpos,ypos
            $a += ($xadj * $k);
            $b -= ($yadj * $k);
            return 'BT ' . sprintf('%.3F %.3F', $a, $b) . ' Td';
        } else if ($type == 're') {    // xpos,ypos,width,height
            $a += ($xadj * $k);
            $b -= ($yadj * $k);
            return sprintf('%.3F %.3F %.3F %.3F', $a, $b, $c, $d) . ' re';
        } else if ($type == 'l') {    // xpos,ypos,x2pos,y2pos
            $a += ($xadj * $k);
            $b -= ($yadj * $k);
            return sprintf('%.3F %.3F l', $a, $b);
        } else if ($type == 'img') {    // width,height,xpos,ypos
            $c += ($xadj * $k);
            $d -= ($yadj * $k);
            return sprintf('q %.3F 0 0 %.3F %.3F %.3F', $a, $b, $c, $d) . ' cm /' . $e;
        } else if ($type == 'draw') {    // xpos,ypos
            $a += ($xadj * $k);
            $b -= ($yadj * $k);
            return sprintf('%.3F %.3F m', $a, $b);
        } else if ($type == 'bezier') {    // xpos,ypos,x2pos,y2pos,x3pos,y3pos
            $a += ($xadj * $k);
            $b -= ($yadj * $k);
            $c += ($xadj * $k);
            $d -= ($yadj * $k);
            $e += ($xadj * $k);
            $f -= ($yadj * $k);
            return sprintf('%.3F %.3F %.3F %.3F %.3F %.3F', $a, $b, $c, $d, $e, $f) . ' c';
        }
    }

    function StartTransform($returnstring = false)
    {
        if ($returnstring) {
            return ('q');
        } else {
            $this->_out('q');
        }
    }

    function transformScale($s_x, $s_y, $x = '', $y = '', $returnstring = false)
    {
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        if (($s_x == 0) OR ($s_y == 0)) {
            $this->Error('Please do not use values equal to zero for scaling');
        }
        $y = ($this->h - $y) * _MPDFK;
        $x *= _MPDFK;
        //calculate elements of transformation matrix
        $s_x /= 100;
        $s_y /= 100;
        $tm[0] = $s_x;
        $tm[1] = 0;
        $tm[2] = 0;
        $tm[3] = $s_y;
        $tm[4] = $x * (1 - $s_x);
        $tm[5] = $y * (1 - $s_y);
        //scale the coordinate system
        if ($returnstring) {
            return ($this->_transform($tm, true));
        } else {
            $this->_transform($tm);
        }
    }

    function _transform($tm, $returnstring = false)
    {
        if ($returnstring) {
            return (sprintf('%.4F %.4F %.4F %.4F %.4F %.4F cm', $tm[0], $tm[1], $tm[2], $tm[3], $tm[4], $tm[5]));
        } else {
            $this->_out(sprintf('%.4F %.4F %.4F %.4F %.4F %.4F cm', $tm[0], $tm[1], $tm[2], $tm[3], $tm[4], $tm[5]));
        }
    }
//----------------------END OF FLOWING BLOCK------------------------------------//


    /*-- CSS-IMAGE-FLOAT --*/
// Update values if set to skipline

    function StopTransform($returnstring = false)
    {
        if ($returnstring) {
            return ('Q');
        } else {
            $this->_out('Q');
        }
    }
    /*-- END CSS-IMAGE-FLOAT --*/


////////////////////////////////////////////////////////////////////////////////
// ADDED forcewrap - to call from inline OBJECT functions to breakwords if necessary in cell
////////////////////////////////////////////////////////////////////////////////

    function printtablebuffer()
    {

        if (!$this->table_rotate) {
            $this->pages[$this->page] .= $this->tablebuffer;
            foreach ($this->tbrot_Links AS $p => $l) {
                foreach ($l AS $v) {
                    $this->PageLinks[$p][] = $v;
                }
            }
            $this->tbrot_Links = array();
            /*-- ANNOTATIONS --*/
            foreach ($this->tbrot_Annots AS $p => $l) {
                foreach ($l AS $v) {
                    $this->PageAnnots[$p][] = $v;
                }
            }
            $this->tbrot_Annots = array();
            /*-- END ANNOTATIONS --*/

            /*-- INDEX --*/
            // Output Reference (index)
            foreach ($this->tbrot_Reference AS $v) {
                $Present = 0;
                for ($i = 0; $i < count($this->Reference); $i++) {
                    if ($this->Reference[$i]['t'] == $v['t']) {
                        $Present = 1;
                        if (!in_array($v['op'], $this->Reference[$i]['p'])) {
                            $this->Reference[$i]['p'][] = $v['op'];
                        }
                    }
                }
                if ($Present == 0) {
                    $this->Reference[] = array('t' => $v['t'], 'p' => array($v['op']));
                }
            }
            $this->tbrot_Reference = array();
            /*-- END INDEX --*/

            /*-- BOOKMARKS --*/
            // Output Bookmarks
            foreach ($this->tbrot_BMoutlines AS $v) {
                $this->BMoutlines[] = array('t' => $v['t'], 'l' => $v['l'], 'y' => $v['y'], 'p' => $v['p']);
            }
            $this->tbrot_BMoutlines = array();
            /*-- END BOOKMARKS --*/

            /*-- TOC --*/
            // Output ToC
            foreach ($this->tbrot_toc AS $v) {
                $this->tocontents->_toc[] = array('t' => $v['t'], 'l' => $v['l'], 'p' => $v['p'], 'link' => $v['link'], 'toc_id' => $v['toc_id']);
            }
            $this->tbrot_toc = array();
            /*-- END TOC --*/

            return;
        }
        // else if rotated
        $lm = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'] + $this->blk[$this->blklvl]['border_left']['w'] + $this->blk[$this->blklvl]['padding_left'];
        $pw = $this->blk[$this->blklvl]['inner_width'];
        //Start Transformation
        $this->pages[$this->page] .= $this->StartTransform(true) . "\n";

        if ($this->table_rotate > 1) {    // clockwise
            if ($this->tbrot_align == 'L') {
                $xadj = $this->tbrot_h;    // align L (as is)
            } else if ($this->tbrot_align == 'R') {
                $xadj = $lm - $this->tbrot_x0 + ($pw);    // align R
            } else {
                $xadj = $lm - $this->tbrot_x0 + (($pw + $this->tbrot_h) / 2);    // align C
            }
            $yadj = 0;
        } else {    // anti-clockwise
            if ($this->tbrot_align == 'L') {
                $xadj = 0;    // align L (as is)
            } else if ($this->tbrot_align == 'R') {
                $xadj = $lm - $this->tbrot_x0 + ($pw - $this->tbrot_h);    // align R
            } else {
                $xadj = $lm - $this->tbrot_x0 + (($pw - $this->tbrot_h) / 2);    // align C
            }
            $yadj = $this->tbrot_w;
        }


        $this->pages[$this->page] .= $this->transformTranslate($xadj, $yadj, true) . "\n";
        $this->pages[$this->page] .= $this->transformRotate($this->table_rotate, $this->tbrot_x0, $this->tbrot_y0, true) . "\n";

        // Now output the adjusted values
        $this->pages[$this->page] .= $this->tablebuffer;


        foreach ($this->tbrot_Links AS $p => $l) {
            foreach ($l AS $v) {
                $w = $v[2] / _MPDFK;
                $h = $v[3] / _MPDFK;
                $ax = ($v[0] / _MPDFK) - $this->tbrot_x0;
                $ay = (($this->hPt - $v[1]) / _MPDFK) - $this->tbrot_y0;
                if ($this->table_rotate > 1) {    // clockwise
                    $bx = $this->tbrot_x0 + $xadj - $ay - $h;
                    $by = $this->tbrot_y0 + $yadj + $ax;
                } else {
                    $bx = $this->tbrot_x0 + $xadj + $ay;
                    $by = $this->tbrot_y0 + $yadj - $ax - $w;
                }
                $v[0] = $bx * _MPDFK;
                $v[1] = ($this->h - $by) * _MPDFK;
                $v[2] = $h * _MPDFK;    // swap width and height
                $v[3] = $w * _MPDFK;
                $this->PageLinks[$p][] = $v;
            }
        }
        $this->tbrot_Links = array();
        foreach ($this->internallink AS $key => $f) {
            if (is_array($f) && isset($f['tbrot'])) {
                $f['Y'] = $this->tbrot_y0;
                $f['PAGE'] = $this->page;
                unset($f['tbrot']);
                $this->internallink[$key] = $f;
            }
        }
        /*-- ANNOTATIONS --*/
        foreach ($this->tbrot_Annots AS $p => $l) {
            foreach ($l AS $v) {
                $ax = abs($v['x']) - $this->tbrot_x0;    // abs because -ve values are internally set and held for reference if annotMargin set
                $ay = $v['y'] - $this->tbrot_y0;
                if ($this->table_rotate > 1) {    // clockwise
                    $bx = $this->tbrot_x0 + $xadj - $ay;
                    $by = $this->tbrot_y0 + $yadj + $ax;
                } else {
                    $bx = $this->tbrot_x0 + $xadj + $ay;
                    $by = $this->tbrot_y0 + $yadj - $ax;
                }
                if ($v['x'] < 0) {
                    $v['x'] = -$bx;
                } else {
                    $v['x'] = $bx;
                }
                $v['y'] = ($by);
                $this->PageAnnots[$p][] = $v;
            }
        }
        $this->tbrot_Annots = array();
        /*-- END ANNOTATIONS --*/


        /*-- BOOKMARKS --*/

        // Adjust Bookmarks
        foreach ($this->tbrot_BMoutlines AS $v) {
            $v['y'] = $this->tbrot_y0;
            $this->BMoutlines[] = array('t' => $v['t'], 'l' => $v['l'], 'y' => $v['y'], 'p' => $this->page);
        }
        /*-- END BOOKMARKS --*/

        /*-- INDEX --*/

        // Adjust Reference (index)
        foreach ($this->tbrot_Reference AS $v) {
            $Present = 0;
            //Search the reference (AND Ref/PageNo) in the array
            for ($i = 0; $i < count($this->Reference); $i++) {
                if ($this->Reference[$i]['t'] == $v['t']) {
                    $Present = 1;
                    if (!in_array($this->page, $this->Reference[$i]['p'])) {
                        $this->Reference[$i]['p'][] = $this->page;
                    }
                }
            }
            if ($Present == 0) {
                $this->Reference[] = array('t' => $v['t'], 'p' => array($this->page));
            }
        }
        /*-- END INDEX --*/

        /*-- TOC --*/

        // Adjust ToC - uses document page number
        foreach ($this->tbrot_toc AS $v) {
            $this->tocontents->_toc[] = array('t' => $v['t'], 'l' => $v['l'], 'p' => $this->page, 'link' => $v['link'], 'toc_id' => $v['toc_id']);
            $this->links[$v['link']][1] = $this->tbrot_y0;
        }
        /*-- END TOC --*/


        $this->tbrot_Reference = array();
        $this->tbrot_BMoutlines = array();
        $this->tbrot_toc = array();

        //Stop Transformation
        $this->pages[$this->page] .= $this->StopTransform(true) . "\n";


        $this->y = $this->tbrot_y0 + $this->tbrot_w;
        $this->x = $this->lMargin;

        $this->tablebuffer = '';
    }

    /*-- END HTML-CSS --*/

    function transformTranslate($t_x, $t_y, $returnstring = false)
    {
        //calculate elements of transformation matrix
        $tm[0] = 1;
        $tm[1] = 0;
        $tm[2] = 0;
        $tm[3] = 1;
        $tm[4] = $t_x * _MPDFK;
        $tm[5] = -$t_y * _MPDFK;
        //translate the coordinate system
        if ($returnstring) {
            return ($this->_transform($tm, true));
        } else {
            $this->_transform($tm);
        }
    }

    function transformRotate($angle, $x = '', $y = '', $returnstring = false)
    {
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        $angle = -$angle;
        $y = ($this->h - $y) * _MPDFK;
        $x *= _MPDFK;
        //calculate elements of transformation matrix
        $tm[0] = cos(deg2rad($angle));
        $tm[1] = sin(deg2rad($angle));
        $tm[2] = -$tm[1];
        $tm[3] = $tm[0];
        $tm[4] = $x + $tm[1] * $y - $tm[0] * $x;
        $tm[5] = $y - $tm[0] * $y - $tm[1] * $x;
        //rotate the coordinate system around ($x,$y)
        if ($returnstring) {
            return ($this->_transform($tm, true));
        } else {
            $this->_transform($tm);
        }
    }

    function AddPage($orientation = '', $condition = '', $resetpagenum = '', $pagenumstyle = '', $suppress = '', $mgl = '', $mgr = '', $mgt = '', $mgb = '', $mgh = '', $mgf = '', $ohname = '', $ehname = '', $ofname = '', $efname = '', $ohvalue = 0, $ehvalue = 0, $ofvalue = 0, $efvalue = 0, $pagesel = '', $newformat = '')
    {
        /*-- CSS-FLOAT --*/
        // Float DIV
        // Cannot do with columns on, or if any change in page orientation/margins etc.
        // If next page already exists - i.e background /headers and footers already written
        if ($this->state > 0 && $this->page < count($this->pages)) {
            $bak_cml = $this->cMarginL;
            $bak_cmr = $this->cMarginR;
            $bak_dw = $this->divwidth;
            // Paint Div Border if necessary
            if ($this->blklvl > 0) {
                $save_tr = $this->table_rotate;    // *TABLES*
                $this->table_rotate = 0;    // *TABLES*
                if ($this->y == $this->blk[$this->blklvl]['y0']) {
                    $this->blk[$this->blklvl]['startpage']++;
                }
                if (($this->y > $this->blk[$this->blklvl]['y0']) || $this->flowingBlockAttr['is_table']) {
                    $toplvl = $this->blklvl;
                } else {
                    $toplvl = $this->blklvl - 1;
                }
                $sy = $this->y;
                for ($bl = 1; $bl <= $toplvl; $bl++) {
                    $this->PaintDivBB('pagebottom', 0, $bl);
                }
                $this->y = $sy;
                $this->table_rotate = $save_tr;    // *TABLES*
            }
            $s = $this->PrintPageBackgrounds();

            // Writes after the marker so not overwritten later by page background etc.
            $this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', '\\1' . "\n" . $s . "\n", $this->pages[$this->page]);
            $this->pageBackgrounds = array();
            $family = $this->FontFamily;
            $style = $this->FontStyle . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');
            $size = $this->FontSizePt;
            $lw = $this->LineWidth;
            $dc = $this->DrawColor;
            $fc = $this->FillColor;
            $tc = $this->TextColor;
            $cf = $this->ColorFlag;

            $this->printfloatbuffer();

            //Move to next page
            $this->page++;
            $this->ResetMargins();
            $this->SetAutoPageBreak($this->autoPageBreak, $this->bMargin);
            $this->x = $this->lMargin;
            $this->y = $this->tMargin;
            $this->FontFamily = '';
            $this->_out('2 J');
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.3F w', $lw * _MPDFK));
            if ($family) $this->SetFont($family, $style, $size, true, true);
            $this->DrawColor = $dc;
            if ($dc != $this->defDrawColor) $this->_out($dc);
            $this->FillColor = $fc;
            if ($fc != $this->defFillColor) $this->_out($fc);
            $this->TextColor = $tc;
            $this->ColorFlag = $cf;
            for ($bl = 1; $bl <= $this->blklvl; $bl++) {
                $this->blk[$bl]['y0'] = $this->y;
                // Don't correct more than once for background DIV containing a Float
                if (!isset($this->blk[$bl]['marginCorrected'][$this->page])) {
                    $this->blk[$bl]['x0'] += $this->MarginCorrection;
                }
                $this->blk[$bl]['marginCorrected'][$this->page] = true;
            }
            $this->cMarginL = $bak_cml;
            $this->cMarginR = $bak_cmr;
            $this->divwidth = $bak_dw;
            return '';
        }
        /*-- END CSS-FLOAT --*/

        //Start a new page
        if ($this->state == 0) $this->Open();

        $bak_cml = $this->cMarginL;
        $bak_cmr = $this->cMarginR;
        $bak_dw = $this->divwidth;


        $bak_lh = $this->lineheight;

        $orientation = substr(strtoupper($orientation), 0, 1);
        $condition = strtoupper($condition);


        if ($condition == 'NEXT-EVEN') {    // always adds at least one new page to create an Even page
            if (!$this->mirrorMargins) {
                $condition = '';
            } else {
                if ($pagesel) {
                    $pbch = $pagesel;
                    $pagesel = '';
                }    // *CSS-PAGE*
                else {
                    $pbch = false;
                }    // *CSS-PAGE*
                $this->AddPage($this->CurOrientation, 'O');
                if ($pbch) {
                    $pagesel = $pbch;
                }    // *CSS-PAGE*
                $condition = '';
            }
        }
        if ($condition == 'NEXT-ODD') {    // always adds at least one new page to create an Odd page
            if (!$this->mirrorMargins) {
                $condition = '';
            } else {
                if ($pagesel) {
                    $pbch = $pagesel;
                    $pagesel = '';
                }    // *CSS-PAGE*
                else {
                    $pbch = false;
                }    // *CSS-PAGE*
                $this->AddPage($this->CurOrientation, 'E');
                if ($pbch) {
                    $pagesel = $pbch;
                }    // *CSS-PAGE*
                $condition = '';
            }
        }


        if ($condition == 'E') {    // only adds new page if needed to create an Even page
            if (!$this->mirrorMargins || ($this->page) % 2 == 0) {
                return false;
            }
        }
        if ($condition == 'O') {    // only adds new page if needed to create an Odd page
            if (!$this->mirrorMargins || ($this->page) % 2 == 1) {
                return false;
            }
        }

        if ($resetpagenum || $pagenumstyle || $suppress) {
            $this->PageNumSubstitutions[] = array('from' => ($this->page + 1), 'reset' => $resetpagenum, 'type' => $pagenumstyle, 'suppress' => $suppress);
        }


        $save_tr = $this->table_rotate;    // *TABLES*
        $this->table_rotate = 0;    // *TABLES*
        $save_kwt = $this->kwt;
        $this->kwt = 0;
        // mPDF 5.6.01 - LAYERS
        $save_layer = $this->current_layer;
        $save_vis = $this->visibility;

        if ($this->visibility != 'visible')
            $this->SetVisibility('visible');
        // mPDF 5.6.01 - LAYERS
        $this->EndLayer();

        // Paint Div Border if necessary
        //PAINTS BACKGROUND COLOUR OR BORDERS for DIV - DISABLED FOR COLUMNS (cf. AcceptPageBreak) AT PRESENT in ->PaintDivBB
        if (!$this->ColActive && $this->blklvl > 0) {
            if (isset($this->blk[$this->blklvl]['y0']) && $this->y == $this->blk[$this->blklvl]['y0']) {
                if (isset($this->blk[$this->blklvl]['startpage'])) {
                    $this->blk[$this->blklvl]['startpage']++;
                } else {
                    $this->blk[$this->blklvl]['startpage'] = 1;
                }
            }
            if ((isset($this->blk[$this->blklvl]['y0']) && $this->y > $this->blk[$this->blklvl]['y0']) || $this->flowingBlockAttr['is_table']) {
                $toplvl = $this->blklvl;
            } else {
                $toplvl = $this->blklvl - 1;
            }
            $sy = $this->y;
            for ($bl = 1; $bl <= $toplvl; $bl++) {

                // mPDF 5.6.01 - LAYERS
                if ($this->blk[$bl]['z-index'] > 0) {
                    $this->BeginLayer($this->blk[$bl]['z-index']);
                }
                if (isset($this->blk[$bl]['visibility']) && $this->blk[$bl]['visibility'] && $this->blk[$bl]['visibility'] != 'visible') {
                    $this->SetVisibility($this->blk[$bl]['visibility']);
                }

                $this->PaintDivBB('pagebottom', 0, $bl);
            }
            $this->y = $sy;
            // RESET block y0 and x0 - see below
        }

        if ($this->visibility != 'visible')
            $this->SetVisibility('visible');
        // mPDF 5.6.01 - LAYERS
        $this->EndLayer();

        // BODY Backgrounds
        if ($this->page > 0) {
            $s = '';
            $s .= $this->PrintBodyBackgrounds();

            $s .= $this->PrintPageBackgrounds();
            $this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', "\n" . $s . "\n" . '\\1', $this->pages[$this->page]);
            $this->pageBackgrounds = array();
        }

        $save_kt = $this->keep_block_together;
        $this->keep_block_together = 0;

        $save_cols = false;
        /*-- COLUMNS --*/
        if ($this->ColActive) {
            $save_cols = true;
            $save_nbcol = $this->NbCol;    // other values of gap and vAlign will not change by setting Columns off
            $this->SetColumns(0);
        }
        /*-- END COLUMNS --*/


        $family = $this->FontFamily;
        $style = $this->FontStyle . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');
        $size = $this->FontSizePt;
        $this->ColumnAdjust = true;    // enables column height adjustment for the page
        $lw = $this->LineWidth;
        $dc = $this->DrawColor;
        $fc = $this->FillColor;
        $tc = $this->TextColor;
        $cf = $this->ColorFlag;
        if ($this->page > 0) {
            //Page footer
            $this->InFooter = true;

            $this->Reset();
            $this->pageoutput[$this->page] = array();

            $this->Footer();
            //Close page
            $this->_endpage();
        }


        //Start new page
        $this->_beginpage($orientation, $mgl, $mgr, $mgt, $mgb, $mgh, $mgf, $ohname, $ehname, $ofname, $efname, $ohvalue, $ehvalue, $ofvalue, $efvalue, $pagesel, $newformat);
        if ($this->docTemplate) {
            $pagecount = $this->SetSourceFile($this->docTemplate);
            if (($this->page - $this->docTemplateStart) > $pagecount) {
                if ($this->docTemplateContinue) {
                    $tplIdx = $this->ImportPage($pagecount);
                    $this->UseTemplate($tplIdx);
                }
            } else {
                $tplIdx = $this->ImportPage(($this->page - $this->docTemplateStart));
                $this->UseTemplate($tplIdx);
            }
        }
        if ($this->pageTemplate) {
            $this->UseTemplate($this->pageTemplate);
        }

        // Tiling Patterns
        $this->_out('___PAGE___START' . $this->uniqstr);
        $this->_out('___BACKGROUND___PATTERNS' . $this->uniqstr);
        $this->_out('___HEADER___MARKER' . $this->uniqstr);
        $this->pageBackgrounds = array();

        //Set line cap style to square
        $this->SetLineCap(2);
        //Set line width
        $this->LineWidth = $lw;
        $this->_out(sprintf('%.3F w', $lw * _MPDFK));
        //Set font
        if ($family) $this->SetFont($family, $style, $size, true, true);    // forces write
        //Set colors
        $this->DrawColor = $dc;
        if ($dc != $this->defDrawColor) $this->_out($dc);
        $this->FillColor = $fc;
        if ($fc != $this->defFillColor) $this->_out($fc);
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;

        //Page header
        $this->Header();

        //Restore line width
        if ($this->LineWidth != $lw) {
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.3F w', $lw * _MPDFK));
        }
        //Restore font
        if ($family) $this->SetFont($family, $style, $size, true, true);    // forces write
        //Restore colors
        if ($this->DrawColor != $dc) {
            $this->DrawColor = $dc;
            $this->_out($dc);
        }
        if ($this->FillColor != $fc) {
            $this->FillColor = $fc;
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
        $this->InFooter = false;

        // mPDF 5.6.01 - LAYERS
        if ($save_layer > 0)
            $this->BeginLayer($save_layer);

        if ($save_vis != 'visible')
            $this->SetVisibility($save_vis);

        /*-- COLUMNS --*/
        if ($save_cols) {
            // Restore columns
            $this->SetColumns($save_nbcol, $this->colvAlign, $this->ColGap);
        }
        if ($this->ColActive) {
            $this->SetCol(0);
        }
        /*-- END COLUMNS --*/


        //RESET BLOCK BORDER TOP
        if (!$this->ColActive) {
            for ($bl = 1; $bl <= $this->blklvl; $bl++) {
                $this->blk[$bl]['y0'] = $this->y;
                if (isset($this->blk[$bl]['x0'])) {
                    $this->blk[$bl]['x0'] += $this->MarginCorrection;
                } else {
                    $this->blk[$bl]['x0'] = $this->MarginCorrection;
                }
                // Added mPDF 3.0 Float DIV
                $this->blk[$bl]['marginCorrected'][$this->page] = true;
            }
        }


        $this->table_rotate = $save_tr;    // *TABLES*
        $this->kwt = $save_kwt;

        $this->keep_block_together = $save_kt;

        $this->cMarginL = $bak_cml;
        $this->cMarginR = $bak_cmr;
        $this->divwidth = $bak_dw;

        $this->lineheight = $bak_lh;
    }



//=============================================================
//=============================================================
//=============================================================
//=============================================================
//=============================================================
    /*-- HTML-CSS --*/

    function PaintDivBB($divider = '', $blockstate = 0, $blvl = 0)
    {
        // Borders & backgrounds are done elsewhere for columns - messes up the repositioning in printcolumnbuffer
        if ($this->ColActive) {
            return;
        }    // *COLUMNS*
        $save_y = $this->y;
        if (!$blvl) {
            $blvl = $this->blklvl;
        }
        $x0 = $x1 = $y0 = $y1 = 0;

        // Added mPDF 3.0 Float DIV
        if (isset($this->blk[$blvl]['bb_painted'][$this->page]) && $this->blk[$blvl]['bb_painted'][$this->page]) {
            return;
        }    // *CSS-FLOAT*

        if (isset($this->blk[$blvl]['x0'])) {
            $x0 = $this->blk[$blvl]['x0'];
        }    // left
        if (isset($this->blk[$blvl]['y1'])) {
            $y1 = $this->blk[$blvl]['y1'];
        }    // bottom

        // Added mPDF 3.0 Float DIV - ensures backgrounds/borders are drawn to bottom of page
        if ($y1 == 0) {
            if ($divider == 'pagebottom') {
                $y1 = $this->h - $this->bMargin;
            } else {
                $y1 = $this->y;
            }
        }

        if (isset($this->blk[$blvl]['startpage']) && $this->blk[$blvl]['startpage'] != $this->page) {
            $continuingpage = true;
        } else {
            $continuingpage = false;
        }

        if (isset($this->blk[$blvl]['y0'])) {
            $y0 = $this->blk[$blvl]['y0'];
        }
        $h = $y1 - $y0;
        $w = $this->blk[$blvl]['width'];
        $x1 = $x0 + $w;

        // Set border-widths as used here
        $border_top = $this->blk[$blvl]['border_top']['w'];
        $border_bottom = $this->blk[$blvl]['border_bottom']['w'];
        $border_left = $this->blk[$blvl]['border_left']['w'];
        $border_right = $this->blk[$blvl]['border_right']['w'];
        if (!$this->blk[$blvl]['border_top'] || $divider == 'pagetop' || $continuingpage) {
            $border_top = 0;
        }
        if (!$this->blk[$blvl]['border_bottom'] || $blockstate == 1 || $divider == 'pagebottom') {
            $border_bottom = 0;
        }

        $brTL_H = 0;
        $brTL_V = 0;
        $brTR_H = 0;
        $brTR_V = 0;
        $brBL_H = 0;
        $brBL_V = 0;
        $brBR_H = 0;
        $brBR_V = 0;

        $brset = false;
        /*-- BORDER-RADIUS --*/
        if (isset($this->blk[$blvl]['border_radius_TL_H'])) {
            $brTL_H = $this->blk[$blvl]['border_radius_TL_H'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_TL_V'])) {
            $brTL_V = $this->blk[$blvl]['border_radius_TL_V'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_TR_H'])) {
            $brTR_H = $this->blk[$blvl]['border_radius_TR_H'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_TR_V'])) {
            $brTR_V = $this->blk[$blvl]['border_radius_TR_V'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_BR_H'])) {
            $brBR_H = $this->blk[$blvl]['border_radius_BR_H'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_BR_V'])) {
            $brBR_V = $this->blk[$blvl]['border_radius_BR_V'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_BL_H'])) {
            $brBL_H = $this->blk[$blvl]['border_radius_BL_H'];
            $brset = true;
        }
        if (isset($this->blk[$blvl]['border_radius_BL_V'])) {
            $brBL_V = $this->blk[$blvl]['border_radius_BL_V'];
            $brset = true;
        }

        // mPDF 5.4.17
        //if (!$this->blk[$blvl]['border_top'] || $divider == 'pagetop' || $continuingpage || $this->keep_block_together) {
        if (!$this->blk[$blvl]['border_top'] || $divider == 'pagetop' || $continuingpage) {
            $brTL_H = 0;
            $brTL_V = 0;
            $brTR_H = 0;
            $brTR_V = 0;
        }
        // mPDF 5.4.17
        //if (!$this->blk[$blvl]['border_bottom'] || $blockstate == 1 || $divider == 'pagebottom' || $this->keep_block_together) {
        if (!$this->blk[$blvl]['border_bottom'] || $blockstate == 1 || $divider == 'pagebottom') {
            $brBL_H = 0;
            $brBL_V = 0;
            $brBR_H = 0;
            $brBR_V = 0;
        }

        // Disallow border-radius if it is smaller than the border width.
        if ($brTL_H < min($border_left, $border_top)) {
            $brTL_H = $brTL_V = 0;
        }
        if ($brTL_V < min($border_left, $border_top)) {
            $brTL_V = $brTL_H = 0;
        }
        if ($brTR_H < min($border_right, $border_top)) {
            $brTR_H = $brTR_V = 0;
        }
        if ($brTR_V < min($border_right, $border_top)) {
            $brTR_V = $brTR_H = 0;
        }
        if ($brBL_H < min($border_left, $border_bottom)) {
            $brBL_H = $brBL_V = 0;
        }
        if ($brBL_V < min($border_left, $border_bottom)) {
            $brBL_V = $brBL_H = 0;
        }
        if ($brBR_H < min($border_right, $border_bottom)) {
            $brBR_H = $brBR_V = 0;
        }
        if ($brBR_V < min($border_right, $border_bottom)) {
            $brBR_V = $brBR_H = 0;
        }

        // CHECK FOR radii that sum to > width or height of div ********
        $f = min($h / ($brTL_V + $brBL_V + 0.001), $h / ($brTR_V + $brBR_V + 0.001), $w / ($brTL_H + $brTR_H + 0.001), $w / ($brBL_H + $brBR_H + 0.001));
        if ($f < 1) {
            $brTL_H *= $f;
            $brTL_V *= $f;
            $brTR_H *= $f;
            $brTR_V *= $f;
            $brBL_H *= $f;
            $brBL_V *= $f;
            $brBR_H *= $f;
            $brBR_V *= $f;
        }
        /*-- END BORDER-RADIUS --*/

        $tbcol = $this->ConvertColor(255);
        for ($l = 0; $l <= $blvl; $l++) {
            if ($this->blk[$l]['bgcolor']) {
                $tbcol = $this->blk[$l]['bgcolorarray'];
            }
        }

        // BORDERS
        if (isset($this->blk[$blvl]['y0']) && $this->blk[$blvl]['y0']) {
            $y0 = $this->blk[$blvl]['y0'];
        }
        $h = $y1 - $y0;
        $w = $this->blk[$blvl]['width'];

        //if ($this->blk[$blvl]['border_top']) {
        // Reinstate line above for dotted line divider when block border crosses a page
        if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
            $tbd = $this->blk[$blvl]['border_top'];

            // mPDF 5.4.18
            $legend = '';
            if (isset($this->blk[$blvl]['border_legend']) && $this->blk[$blvl]['border_legend']) {
                $legend = $this->blk[$blvl]['border_legend'];    // Same structure array as textbuffer
                $txt = ltrim($legend[0]);

                //Set font, size, style, color
                $this->SetFont($legend[4], $legend[2], $legend[11]);
                if ($legend[3]) {
                    $cor = $legend[3];
                    $this->SetTColor($cor);
                }
                $stringWidth = $this->GetStringWidth($txt);
                $save_x = $this->x;
                $save_y = $this->y;
                $save_currentfontfamily = $this->FontFamily;
                $save_currentfontsize = $this->FontSizePt;
                $save_currentfontstyle = $this->FontStyle . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');
                $this->y = $y0 - $this->FontSize / 2 + $this->blk[$blvl]['border_top']['w'] / 2;
                $this->x = $x0 + $this->blk[$blvl]['padding_left'] + $this->blk[$blvl]['border_left']['w'];

                // Set the distance from the border line to the text ? make configurable variable
                $gap = 0.2 * $this->FontSize;

                $legbreakL = $this->x - $gap;
                $legbreakR = $this->x + $stringWidth + $gap;

                $this->Cell($stringWidth, $this->FontSize, $txt, '', 0, 'C', $fill, '', 0, 0, 0, 'M', $fill);
                // Reset
                $this->x = $save_x;
                $this->y = $save_y;
                $this->SetFont($save_currentfontfamily, $save_currentfontstyle, $save_currentfontsize);
                $this->SetTColor($this->ConvertColor(0));
            }

            if (isset($tbd['s']) && $tbd['s']) {
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('q');
                    $this->SetLineWidth(0);
                    $this->_out(sprintf('%.3F %.3F m ', ($x0) * _MPDFK, ($this->h - ($y0)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $border_left) * _MPDFK, ($this->h - ($y0 + $border_top)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w - $border_right) * _MPDFK, ($this->h - ($y0 + $border_top)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w) * _MPDFK, ($this->h - ($y0)) * _MPDFK));
                    $this->_out(' h W n ');    // Ends path no-op & Sets the clipping path
                }

                $this->_setBorderLine($tbd);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $legbreakL -= $border_top / 2;    // because line cap different
                    $legbreakR += $border_top / 2;
                    $this->_setDashBorder($tbd['style'], $divider, $continuingpage, 'T');
                } /*-- BORDER-RADIUS --*/
                else if (($brTL_V && $brTL_H) || ($brTR_V && $brTR_H) || $tbd['style'] == 'solid' || $tbd['style'] == 'double') {  // mPDF 5.6.58
                    $this->SetLineJoin(0);
                    $this->SetLineCap(0);
                }
                $s = '';
                if ($brTR_H && $brTR_V) {
                    $s .= ($this->_EllipseArc($x0 + $w - $brTR_H, $y0 + $brTR_V, $brTR_H - $border_top / 2, $brTR_V - $border_top / 2, 1, 2, true)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + $w) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + $w - ($border_top / 2)) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                    }
                /*-- BORDER-RADIUS --*/
                if ($brTL_H && $brTL_V) {
                    // mPDF 5.4.18
                    if ($legend) {
                        if ($legbreakR < ($x0 + $w - $brTR_H)) {
                            $s .= (sprintf('%.3F %.3F l ', $legbreakR * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                        }
                        if ($legbreakL > ($x0 + $brTL_H)) {
                            $s .= (sprintf('%.3F %.3F m ', $legbreakL * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                            $s .= (sprintf('%.3F %.3F l ', ($x0 + $brTL_H) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK) . "\n");
                        } else {
                            $s .= (sprintf('%.3F %.3F m ', ($x0 + $brTL_H) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                        }
                    } else {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + $brTL_H) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                    }
                    $s .= ($this->_EllipseArc($x0 + $brTL_H, $y0 + $brTL_V, $brTL_H - $border_top / 2, $brTL_V - $border_top / 2, 2, 1)) . "\n";
                } else {
                    /*-- END BORDER-RADIUS --*/
                    // mPDF 5.4.18
                    if ($legend) {
                        if ($legbreakR < ($x0 + $w)) {
                            $s .= (sprintf('%.3F %.3F l ', $legbreakR * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                        }
                        if ($legbreakL > ($x0)) {
                            $s .= (sprintf('%.3F %.3F m ', $legbreakL * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                            if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                                $s .= (sprintf('%.3F %.3F l ', ($x0) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                            } else {
                                $s .= (sprintf('%.3F %.3F l ', ($x0 + ($border_top / 2)) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                            }
                        } else if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                            $s .= (sprintf('%.3F %.3F m ', ($x0) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                        } else {
                            $s .= (sprintf('%.3F %.3F m ', ($x0 + $border_top / 2) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                        }
                    } else if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F l ', ($x0) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + ($border_top / 2)) * _MPDFK, ($this->h - ($y0 + ($border_top / 2))) * _MPDFK)) . "\n";
                    }
                    /*-- BORDER-RADIUS --*/
                }
                /*-- END BORDER-RADIUS --*/
                $s .= 'S' . "\n";
                $this->_out($s);

                if ($tbd['style'] == 'double') {
                    $this->SetLineWidth($tbd['w'] / 3);
                    $this->SetDColor($tbcol);
                    $this->_out($s);
                }
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('Q');
                }

                // Reset Corners and Dash off
                $this->SetLineWidth(0.1);    // mPDF 5.6.57
                $this->SetDColor($this->ConvertColor(0));
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        //if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1) {
        // Reinstate line above for dotted line divider when block border crosses a page
        if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
            $tbd = $this->blk[$blvl]['border_bottom'];
            if (isset($tbd['s']) && $tbd['s']) {
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('q');
                    $this->SetLineWidth(0);
                    $this->_out(sprintf('%.3F %.3F m ', ($x0) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $border_left) * _MPDFK, ($this->h - ($y0 + $h - $border_bottom)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w - $border_right) * _MPDFK, ($this->h - ($y0 + $h - $border_bottom)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK));
                    $this->_out(' h W n ');    // Ends path no-op & Sets the clipping path
                }

                $this->_setBorderLine($tbd);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], $divider, $continuingpage, 'B');
                } /*-- BORDER-RADIUS --*/
                else if (($brBL_V && $brBL_H) || ($brBR_V && $brBR_H) || $tbd['style'] == 'solid' || $tbd['style'] == 'double') {  // mPDF 5.6.58
                    $this->SetLineJoin(0);
                    $this->SetLineCap(0);
                }
                $s = '';
                if ($brBL_H && $brBL_V) {
                    $s .= ($this->_EllipseArc($x0 + $brBL_H, $y0 + $h - $brBL_V, $brBL_H - $border_bottom / 2, $brBL_V - $border_bottom / 2, 3, 2, true)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F m ', ($x0) * _MPDFK, ($this->h - ($y0 + $h - ($border_bottom / 2))) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + ($border_bottom / 2)) * _MPDFK, ($this->h - ($y0 + $h - ($border_bottom / 2))) * _MPDFK)) . "\n";
                    }
                /*-- BORDER-RADIUS --*/
                if ($brBR_H && $brBR_V) {
                    $s .= (sprintf('%.3F %.3F l ', ($x0 + $w - ($border_bottom / 2) - $brBR_H) * _MPDFK, ($this->h - ($y0 + $h - ($border_bottom / 2))) * _MPDFK)) . "\n";
                    $s .= ($this->_EllipseArc($x0 + $w - $brBR_H, $y0 + $h - $brBR_V, $brBR_H - $border_bottom / 2, $brBR_V - $border_bottom / 2, 4, 1)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + $w) * _MPDFK, ($this->h - ($y0 + $h - ($border_bottom / 2))) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + $w - ($border_bottom / 2)) * _MPDFK, ($this->h - ($y0 + $h - ($border_bottom / 2))) * _MPDFK)) . "\n";
                    }
                $s .= 'S' . "\n";
                $this->_out($s);

                if ($tbd['style'] == 'double') {
                    $this->SetLineWidth($tbd['w'] / 3);
                    $this->SetDColor($tbcol);
                    $this->_out($s);
                }
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('Q');
                }


                // Reset Corners and Dash off
                $this->SetLineWidth(0.1);    // mPDF 5.6.57
                $this->SetDColor($this->ConvertColor(0));
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        if ($this->blk[$blvl]['border_left']) {
            $tbd = $this->blk[$blvl]['border_left'];
            if (isset($tbd['s']) && $tbd['s']) {
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('q');
                    $this->SetLineWidth(0);
                    $this->_out(sprintf('%.3F %.3F m ', ($x0) * _MPDFK, ($this->h - ($y0)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $border_left) * _MPDFK, ($this->h - ($y0 + $border_top)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $border_left) * _MPDFK, ($this->h - ($y0 + $h - $border_bottom)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK));
                    $this->_out(' h W n ');    // Ends path no-op & Sets the clipping path
                }

                $this->_setBorderLine($tbd);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], $divider, $continuingpage, 'L');
                } /*-- BORDER-RADIUS --*/
                else if (($brTL_V && $brTL_H) || ($brBL_V && $brBL_H) || $tbd['style'] == 'solid' || $tbd['style'] == 'double') {  // mPDF 5.6.58
                    $this->SetLineJoin(0);
                    $this->SetLineCap(0);
                }
                $s = '';
                if ($brTL_V && $brTL_H) {
                    $s .= ($this->_EllipseArc($x0 + $brTL_H, $y0 + $brTL_V, $brTL_H - $border_left / 2, $brTL_V - $border_left / 2, 2, 2, true)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + ($border_left / 2)) * _MPDFK, ($this->h - ($y0)) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + ($border_left / 2)) * _MPDFK, ($this->h - ($y0 + ($border_left / 2))) * _MPDFK)) . "\n";
                    }
                /*-- BORDER-RADIUS --*/
                if ($brBL_V && $brBL_H) {
                    $s .= (sprintf('%.3F %.3F l ', ($x0 + ($border_left / 2)) * _MPDFK, ($this->h - ($y0 + $h - ($border_left / 2) - $brBL_V)) * _MPDFK)) . "\n";
                    $s .= ($this->_EllipseArc($x0 + $brBL_H, $y0 + $h - $brBL_V, $brBL_H - $border_left / 2, $brBL_V - $border_left / 2, 3, 1)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + ($border_left / 2)) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + ($border_left / 2)) * _MPDFK, ($this->h - ($y0 + $h - ($border_left / 2))) * _MPDFK)) . "\n";
                    }
                $s .= 'S' . "\n";
                $this->_out($s);

                if ($tbd['style'] == 'double') {
                    $this->SetLineWidth($tbd['w'] / 3);
                    $this->SetDColor($tbcol);
                    $this->_out($s);
                }
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('Q');
                }

                // Reset Corners and Dash off
                $this->SetLineWidth(0.1);    // mPDF 5.6.57
                $this->SetDColor($this->ConvertColor(0));
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        if ($this->blk[$blvl]['border_right']) {
            $tbd = $this->blk[$blvl]['border_right'];
            if (isset($tbd['s']) && $tbd['s']) {
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('q');
                    $this->SetLineWidth(0);
                    $this->_out(sprintf('%.3F %.3F m ', ($x0 + $w) * _MPDFK, ($this->h - ($y0)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w - $border_right) * _MPDFK, ($this->h - ($y0 + $border_top)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w - $border_right) * _MPDFK, ($this->h - ($y0 + $h - $border_bottom)) * _MPDFK));
                    $this->_out(sprintf('%.3F %.3F l ', ($x0 + $w) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK));
                    $this->_out(' h W n ');    // Ends path no-op & Sets the clipping path
                }

                $this->_setBorderLine($tbd);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], $divider, $continuingpage, 'R');
                } /*-- BORDER-RADIUS --*/
                else if (($brTR_V && $brTR_H) || ($brBR_V && $brBR_H) || $tbd['style'] == 'solid' || $tbd['style'] == 'double') { // mPDF 5.6.58
                    $this->SetLineJoin(0);
                    $this->SetLineCap(0);
                }
                $s = '';
                if ($brBR_V && $brBR_H) {
                    $s .= ($this->_EllipseArc($x0 + $w - $brBR_H, $y0 + $h - $brBR_V, $brBR_H - $border_right / 2, $brBR_V - $border_right / 2, 4, 2, true)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + $w - ($border_right / 2)) * _MPDFK, ($this->h - ($y0 + $h)) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F m ', ($x0 + $w - ($border_right / 2)) * _MPDFK, ($this->h - ($y0 + $h - ($border_right / 2))) * _MPDFK)) . "\n";
                    }
                /*-- BORDER-RADIUS --*/
                if ($brTR_V && $brTR_H) {
                    $s .= (sprintf('%.3F %.3F l ', ($x0 + $w - ($border_right / 2)) * _MPDFK, ($this->h - ($y0 + ($border_right / 2) + $brTR_V)) * _MPDFK)) . "\n";
                    $s .= ($this->_EllipseArc($x0 + $w - $brTR_H, $y0 + $brTR_V, $brTR_H - $border_right / 2, $brTR_V - $border_right / 2, 1, 1)) . "\n";
                } else
                    /*-- END BORDER-RADIUS --*/
                    if ($tbd['style'] == 'solid' || $tbd['style'] == 'double') {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + $w - ($border_right / 2)) * _MPDFK, ($this->h - ($y0)) * _MPDFK)) . "\n";
                    } else {
                        $s .= (sprintf('%.3F %.3F l ', ($x0 + $w - ($border_right / 2)) * _MPDFK, ($this->h - ($y0 + ($border_right / 2))) * _MPDFK)) . "\n";
                    }
                $s .= 'S' . "\n";
                $this->_out($s);

                if ($tbd['style'] == 'double') {
                    $this->SetLineWidth($tbd['w'] / 3);
                    $this->SetDColor($tbcol);
                    $this->_out($s);
                }
                if (!$brset && $tbd['style'] != 'dotted' && $tbd['style'] != 'dashed') {
                    $this->_out('Q');
                }

                // Reset Corners and Dash off
                $this->SetLineWidth(0.1);    // mPDF 5.6.57
                $this->SetDColor($this->ConvertColor(0));
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }


        $this->SetDash();
        $this->y = $save_y;


        // BACKGROUNDS are disabled in columns/kbt/headers - messes up the repositioning in printcolumnbuffer
        if ($this->ColActive || $this->kwt || $this->keep_block_together) {
            return;
        }


        $bgx0 = $x0;
        $bgx1 = $x1;
        $bgy0 = $y0;
        $bgy1 = $y1;

        // Defined br values represent the radius of the outer curve - need to take border-width/2 from each radius for drawing the borders
        if (isset($this->blk[$blvl]['background_clip']) && $this->blk[$blvl]['background_clip'] == 'padding-box') {
            $brbgTL_H = max(0, $brTL_H - $this->blk[$blvl]['border_left']['w']);
            $brbgTL_V = max(0, $brTL_V - $this->blk[$blvl]['border_top']['w']);
            $brbgTR_H = max(0, $brTR_H - $this->blk[$blvl]['border_right']['w']);
            $brbgTR_V = max(0, $brTR_V - $this->blk[$blvl]['border_top']['w']);
            $brbgBL_H = max(0, $brBL_H - $this->blk[$blvl]['border_left']['w']);
            $brbgBL_V = max(0, $brBL_V - $this->blk[$blvl]['border_bottom']['w']);
            $brbgBR_H = max(0, $brBR_H - $this->blk[$blvl]['border_right']['w']);
            $brbgBR_V = max(0, $brBR_V - $this->blk[$blvl]['border_bottom']['w']);
            $bgx0 += $this->blk[$blvl]['border_left']['w'];
            $bgx1 -= $this->blk[$blvl]['border_right']['w'];
            if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
                $bgy0 += $this->blk[$blvl]['border_top']['w'];
            }
            if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
                $bgy1 -= $this->blk[$blvl]['border_bottom']['w'];
            }
        } // mPDF 5.6.09
        else if (isset($this->blk[$blvl]['background_clip']) && $this->blk[$blvl]['background_clip'] == 'content-box') {
            $brbgTL_H = max(0, $brTL_H - $this->blk[$blvl]['border_left']['w'] - $this->blk[$blvl]['padding_left']);
            $brbgTL_V = max(0, $brTL_V - $this->blk[$blvl]['border_top']['w'] - $this->blk[$blvl]['padding_top']);
            $brbgTR_H = max(0, $brTR_H - $this->blk[$blvl]['border_right']['w'] - $this->blk[$blvl]['padding_right']);
            $brbgTR_V = max(0, $brTR_V - $this->blk[$blvl]['border_top']['w'] - $this->blk[$blvl]['padding_top']);
            $brbgBL_H = max(0, $brBL_H - $this->blk[$blvl]['border_left']['w'] - $this->blk[$blvl]['padding_left']);
            $brbgBL_V = max(0, $brBL_V - $this->blk[$blvl]['border_bottom']['w'] - $this->blk[$blvl]['padding_bottom']);
            $brbgBR_H = max(0, $brBR_H - $this->blk[$blvl]['border_right']['w'] - $this->blk[$blvl]['padding_right']);
            $brbgBR_V = max(0, $brBR_V - $this->blk[$blvl]['border_bottom']['w'] - $this->blk[$blvl]['padding_bottom']);
            $bgx0 += $this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['padding_left'];
            $bgx1 -= $this->blk[$blvl]['border_right']['w'] + $this->blk[$blvl]['padding_right'];
            if (($this->blk[$blvl]['border_top']['w'] || $this->blk[$blvl]['padding_top']) && $divider != 'pagetop' && !$continuingpage) {
                $bgy0 += $this->blk[$blvl]['border_top']['w'] + $this->blk[$blvl]['padding_top'];
            }
            if (($this->blk[$blvl]['border_bottom']['w'] || $this->blk[$blvl]['padding_bottom']) && $blockstate != 1 && $divider != 'pagebottom') {
                $bgy1 -= $this->blk[$blvl]['border_bottom']['w'] + $this->blk[$blvl]['padding_bottom'];
            }
        } else {
            $brbgTL_H = $brTL_H;
            $brbgTL_V = $brTL_V;
            $brbgTR_H = $brTR_H;
            $brbgTR_V = $brTR_V;
            $brbgBL_H = $brBL_H;
            $brbgBL_V = $brBL_V;
            $brbgBR_H = $brBR_H;
            $brbgBR_V = $brBR_V;
        }

        // Set clipping path
        $s = ' q 0 w ';    // Line width=0
        $s .= sprintf('%.3F %.3F m ', ($bgx0 + $brbgTL_H) * _MPDFK, ($this->h - $bgy0) * _MPDFK);    // start point TL before the arc
        /*-- BORDER-RADIUS --*/
        if ($brbgTL_H || $brbgTL_V) {
            $s .= $this->_EllipseArc($bgx0 + $brbgTL_H, $bgy0 + $brbgTL_V, $brbgTL_H, $brbgTL_V, 2);    // segment 2 TL
        }
        /*-- END BORDER-RADIUS --*/
        $s .= sprintf('%.3F %.3F l ', ($bgx0) * _MPDFK, ($this->h - ($bgy1 - $brbgBL_V)) * _MPDFK);    // line to BL
        /*-- BORDER-RADIUS --*/
        if ($brbgBL_H || $brbgBL_V) {
            $s .= $this->_EllipseArc($bgx0 + $brbgBL_H, $bgy1 - $brbgBL_V, $brbgBL_H, $brbgBL_V, 3);    // segment 3 BL
        }
        /*-- END BORDER-RADIUS --*/
        $s .= sprintf('%.3F %.3F l ', ($bgx1 - $brbgBR_H) * _MPDFK, ($this->h - ($bgy1)) * _MPDFK);    // line to BR
        /*-- BORDER-RADIUS --*/
        if ($brbgBR_H || $brbgBR_V) {
            $s .= $this->_EllipseArc($bgx1 - $brbgBR_H, $bgy1 - $brbgBR_V, $brbgBR_H, $brbgBR_V, 4);    // segment 4 BR
        }
        /*-- END BORDER-RADIUS --*/
        $s .= sprintf('%.3F %.3F l ', ($bgx1) * _MPDFK, ($this->h - ($bgy0 + $brbgTR_V)) * _MPDFK);    // line to TR
        /*-- BORDER-RADIUS --*/
        if ($brbgTR_H || $brbgTR_V) {
            $s .= $this->_EllipseArc($bgx1 - $brbgTR_H, $bgy0 + $brbgTR_V, $brbgTR_H, $brbgTR_V, 1);    // segment 1 TR
        }
        /*-- END BORDER-RADIUS --*/
        $s .= sprintf('%.3F %.3F l ', ($bgx0 + $brbgTL_H) * _MPDFK, ($this->h - $bgy0) * _MPDFK);    // line to TL


        // Box Shadow
        $shadow = '';
        if (isset($this->blk[$blvl]['box_shadow']) && $this->blk[$blvl]['box_shadow'] && $h > 0) {
            foreach ($this->blk[$blvl]['box_shadow'] AS $sh) {
                // Colors
                if ($sh['col']{0} == 1) {
                    $colspace = 'Gray';
                    if ($sh['col']{2} == 1) {
                        $col1 = '1' . $sh['col'][1] . '1' . $sh['col'][3];
                    } else {
                        $col1 = '1' . $sh['col'][1] . '1' . chr(100);
                    }
                    $col2 = '1' . $sh['col'][1] . '1' . chr(0);
                } else if ($sh['col']{0} == 4) {    // CMYK
                    $colspace = 'CMYK';
                    $col1 = '6' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . $sh['col'][4] . chr(100);
                    $col2 = '6' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . $sh['col'][4] . chr(0);
                } else if ($sh['col']{0} == 5) {    // RGBa
                    $colspace = 'RGB';
                    $col1 = '5' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . $sh['col'][4];
                    $col2 = '5' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . chr(0);
                } else if ($sh['col']{0} == 6) {    // CMYKa
                    $colspace = 'CMYK';
                    $col1 = '6' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . $sh['col'][4] . $sh['col'][5];
                    $col2 = '6' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . $sh['col'][4] . chr(0);
                } else {
                    $colspace = 'RGB';
                    $col1 = '5' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . chr(100);
                    $col2 = '5' . $sh['col'][1] . $sh['col'][2] . $sh['col'][3] . chr(0);
                }

                // Use clipping path as set above (and rectangle around page) to clip area outside box
                $shadow .= $s;    // Use the clipping path with W*
                $shadow .= sprintf('0 %.3F m %.3F %.3F l ', $this->h * _MPDFK, $this->w * _MPDFK, $this->h * _MPDFK);
                $shadow .= sprintf('%.3F 0 l 0 0 l 0 %.3F l ', $this->w * _MPDFK, $this->h * _MPDFK);
                $shadow .= 'W n' . "\n";

                $sh['blur'] = abs($sh['blur']);    // cannot have negative blur value
                // Ensure spread/blur do not make effective shadow width/height < 0
                // Could do more complex things but this just adjusts spread value
                if (-$sh['spread'] + $sh['blur'] / 2 > min($w / 2, $h / 2)) {
                    $sh['spread'] = $sh['blur'] / 2 - min($w / 2, $h / 2) + 0.01;
                }
                // Shadow Offset
                if ($sh['x'] || $sh['y']) $shadow .= sprintf(' q 1 0 0 1 %.4F %.4F cm', $sh['x'] * _MPDFK, -$sh['y'] * _MPDFK) . "\n";

                // Set path for INNER shadow
                $shadow .= ' q 0 w ';
                $shadow .= $this->SetFColor($col1, true) . "\n";
                if ($col1{0} == 5 && ord($col1{4}) < 100) {    // RGBa
                    $shadow .= $this->SetAlpha(ord($col1{4}) / 100, 'Normal', true, 'F') . "\n";
                } else if ($col1{0} == 6 && ord($col1{5}) < 100) {    // CMYKa
                    $shadow .= $this->SetAlpha(ord($col1{5}) / 100, 'Normal', true, 'F') . "\n";
                } else if ($col1{0} == 1 && $col1{2} == 1 && ord($col1{3}) < 100) {    // Gray
                    $shadow .= $this->SetAlpha(ord($col1{3}) / 100, 'Normal', true, 'F') . "\n";
                }

                // Blur edges
                $mag = 0.551784;    // Bezier Control magic number for 4-part spline for circle/ellipse
                $mag2 = 0.551784;    // Bezier Control magic number to fill in edge of blurred rectangle
                $d1 = $sh['spread'] + $sh['blur'] / 2;
                $d2 = $sh['spread'] - $sh['blur'] / 2;
                $bl = $sh['blur'];
                $x00 = $x0 - $d1;
                $y00 = $y0 - $d1;
                $w00 = $w + $d1 * 2;
                $h00 = $h + $d1 * 2;

                // If any border-radius is greater width-negative spread(inner edge), ignore radii for shadow or screws up
                $flatten = false;
                if (max($brbgTR_H, $brbgTL_H, $brbgBR_H, $brbgBL_H) >= $w + $d2) {
                    $flatten = true;
                }
                if (max($brbgTR_V, $brbgTL_V, $brbgBR_V, $brbgBL_V) >= $h + $d2) {
                    $flatten = true;
                }


                // TOP RIGHT corner
                $p1x = $x00 + $w00 - $d1 - $brbgTR_H;
                $p1c2x = $p1x + ($d2 + $brbgTR_H) * $mag;
                $p1y = $y00 + $bl;
                $p2x = $x00 + $w00 - $d1 - $brbgTR_H;
                $p2c2x = $p2x + ($d1 + $brbgTR_H) * $mag;
                $p2y = $y00;
                $p2c1y = $p2y + $bl / 2;
                $p3x = $x00 + $w00;
                $p3c2x = $p3x - $bl / 2;
                $p3y = $y00 + $d1 + $brbgTR_V;
                $p3c1y = $p3y - ($d1 + $brbgTR_V) * $mag;
                $p4x = $x00 + $w00 - $bl;
                $p4y = $y00 + $d1 + $brbgTR_V;
                $p4c2y = $p4y - ($d2 + $brbgTR_V) * $mag;
                if (-$d2 > min($brbgTR_H, $brbgTR_V) || $flatten) {
                    $p1x = $x00 + $w00 - $bl;
                    $p1c2x = $p1x;
                    $p2x = $x00 + $w00 - $bl;
                    $p2c2x = $p2x + $bl * $mag2;
                    $p3y = $y00 + $bl;
                    $p3c1y = $p3y - $bl * $mag2;
                    $p4y = $y00 + $bl;
                    $p4c2y = $p4y;
                }

                $shadow .= sprintf('%.3F %.3F m ', ($p1x) * _MPDFK, ($this->h - ($p1y)) * _MPDFK);
                $shadow .= sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', ($p1c2x) * _MPDFK, ($this->h - ($p1y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4c2y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK);
                $patch_array[0]['f'] = 0;
                $patch_array[0]['points'] = array($p1x, $p1y, $p1x, $p1y,
                    $p2x, $p2c1y, $p2x, $p2y, $p2c2x, $p2y,
                    $p3x, $p3c1y, $p3x, $p3y, $p3c2x, $p3y,
                    $p4x, $p4y, $p4x, $p4y, $p4x, $p4c2y,
                    $p1c2x, $p1y);
                $patch_array[0]['colors'] = array($col1, $col2, $col2, $col1);


                // RIGHT
                $p1x = $x00 + $w00;    // control point only matches p3 preceding
                $p1y = $y00 + $d1 + $brbgTR_V;
                $p2x = $x00 + $w00 - $bl;    // control point only matches p4 preceding
                $p2y = $y00 + $d1 + $brbgTR_V;
                $p3x = $x00 + $w00 - $bl;
                $p3y = $y00 + $h00 - $d1 - $brbgBR_V;
                $p4x = $x00 + $w00;
                $p4c1x = $p4x - $bl / 2;
                $p4y = $y00 + $h00 - $d1 - $brbgBR_V;
                if (-$d2 > min($brbgTR_H, $brbgTR_V) || $flatten) {
                    $p1y = $y00 + $bl;
                    $p2y = $y00 + $bl;
                }
                if (-$d2 > min($brbgBR_H, $brbgBR_V) || $flatten) {
                    $p3y = $y00 + $h00 - $bl;
                    $p4y = $y00 + $h00 - $bl;
                }

                $shadow .= sprintf('%.3F %.3F l ', ($p3x) * _MPDFK, ($this->h - ($p3y)) * _MPDFK);
                $patch_array[1]['f'] = 2;
                $patch_array[1]['points'] = array($p2x, $p2y,
                    $p3x, $p3y, $p3x, $p3y, $p3x, $p3y,
                    $p4c1x, $p4y, $p4x, $p4y, $p4x, $p4y,
                    $p1x, $p1y);
                $patch_array[1]['colors'] = array($col1, $col2);


                // BOTTOM RIGHT corner
                $p1x = $x00 + $w00 - $bl;        // control points only matches p3 preceding
                $p1y = $y00 + $h00 - $d1 - $brbgBR_V;
                $p1c2y = $p1y + ($d2 + $brbgBR_V) * $mag;
                $p2x = $x00 + $w00;                    // control point only matches p4 preceding
                $p2y = $y00 + $h00 - $d1 - $brbgBR_V;
                $p2c2y = $p2y + ($d1 + $brbgBR_V) * $mag;
                $p3x = $x00 + $w00 - $d1 - $brbgBR_H;
                $p3c1x = $p3x + ($d1 + $brbgBR_H) * $mag;
                $p3y = $y00 + $h00;
                $p3c2y = $p3y - $bl / 2;
                $p4x = $x00 + $w00 - $d1 - $brbgBR_H;
                $p4c2x = $p4x + ($d2 + $brbgBR_H) * $mag;
                $p4y = $y00 + $h00 - $bl;

                if (-$d2 > min($brbgBR_H, $brbgBR_V) || $flatten) {
                    $p1y = $y00 + $h00 - $bl;
                    $p1c2y = $p1y;
                    $p2y = $y00 + $h00 - $bl;
                    $p2c2y = $p2y + $bl * $mag2;
                    $p3x = $x00 + $w00 - $bl;
                    $p3c1x = $p3x + $bl * $mag2;
                    $p4x = $x00 + $w00 - $bl;
                    $p4c2x = $p4x;
                }

                $shadow .= sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', ($p1x) * _MPDFK, ($this->h - ($p1c2y)) * _MPDFK, ($p4c2x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK);
                $patch_array[2]['f'] = 2;
                $patch_array[2]['points'] = array($p2x, $p2c2y,
                    $p3c1x, $p3y, $p3x, $p3y, $p3x, $p3c2y,
                    $p4x, $p4y, $p4x, $p4y, $p4c2x, $p4y,
                    $p1x, $p1c2y);
                $patch_array[2]['colors'] = array($col2, $col1);


                // BOTTOM
                $p1x = $x00 + $w00 - $d1 - $brbgBR_H;    // control point only matches p3 preceding
                $p1y = $y00 + $h00;
                $p2x = $x00 + $w00 - $d1 - $brbgBR_H;    // control point only matches p4 preceding
                $p2y = $y00 + $h00 - $bl;
                $p3x = $x00 + $d1 + $brbgBL_H;
                $p3y = $y00 + $h00 - $bl;
                $p4x = $x00 + $d1 + $brbgBL_H;
                $p4y = $y00 + $h00;
                $p4c1y = $p4y - $bl / 2;

                if (-$d2 > min($brbgBR_H, $brbgBR_V) || $flatten) {
                    $p1x = $x00 + $w00 - $bl;
                    $p2x = $x00 + $w00 - $bl;
                }
                if (-$d2 > min($brbgBL_H, $brbgBL_V) || $flatten) {
                    $p3x = $x00 + $bl;
                    $p4x = $x00 + $bl;
                }

                $shadow .= sprintf('%.3F %.3F l ', ($p3x) * _MPDFK, ($this->h - ($p3y)) * _MPDFK);
                $patch_array[3]['f'] = 2;
                $patch_array[3]['points'] = array($p2x, $p2y,
                    $p3x, $p3y, $p3x, $p3y, $p3x, $p3y,
                    $p4x, $p4c1y, $p4x, $p4y, $p4x, $p4y,
                    $p1x, $p1y);
                $patch_array[3]['colors'] = array($col1, $col2);

                // BOTTOM LEFT corner
                $p1x = $x00 + $d1 + $brbgBL_H;
                $p1c2x = $p1x - ($d2 + $brbgBL_H) * $mag;    // control points only matches p3 preceding
                $p1y = $y00 + $h00 - $bl;
                $p2x = $x00 + $d1 + $brbgBL_H;
                $p2c2x = $p2x - ($d1 + $brbgBL_H) * $mag;    // control point only matches p4 preceding
                $p2y = $y00 + $h00;
                $p3x = $x00;
                $p3c2x = $p3x + $bl / 2;
                $p3y = $y00 + $h00 - $d1 - $brbgBL_V;
                $p3c1y = $p3y + ($d1 + $brbgBL_V) * $mag;
                $p4x = $x00 + $bl;
                $p4y = $y00 + $h00 - $d1 - $brbgBL_V;
                $p4c2y = $p4y + ($d2 + $brbgBL_V) * $mag;
                if (-$d2 > min($brbgBL_H, $brbgBL_V) || $flatten) {
                    $p1x = $x00 + $bl;
                    $p1c2x = $p1x;
                    $p2x = $x00 + $bl;
                    $p2c2x = $p2x - $bl * $mag2;
                    $p3y = $y00 + $h00 - $bl;
                    $p3c1y = $p3y + $bl * $mag2;
                    $p4y = $y00 + $h00 - $bl;
                    $p4c2y = $p4y;
                }

                $shadow .= sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', ($p1c2x) * _MPDFK, ($this->h - ($p1y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4c2y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK);
                $patch_array[4]['f'] = 2;
                $patch_array[4]['points'] = array($p2c2x, $p2y,
                    $p3x, $p3c1y, $p3x, $p3y, $p3c2x, $p3y,
                    $p4x, $p4y, $p4x, $p4y, $p4x, $p4c2y,
                    $p1c2x, $p1y);
                $patch_array[4]['colors'] = array($col2, $col1);


                // LEFT - joins on the right (C3-C4 of previous): f = 2
                $p1x = $x00;    // control point only matches p3 preceding
                $p1y = $y00 + $h00 - $d1 - $brbgBL_V;
                $p2x = $x00 + $bl;    // control point only matches p4 preceding
                $p2y = $y00 + $h00 - $d1 - $brbgBL_V;
                $p3x = $x00 + $bl;
                $p3y = $y00 + $d1 + $brbgTL_V;
                $p4x = $x00;
                $p4c1x = $p4x + $bl / 2;
                $p4y = $y00 + $d1 + $brbgTL_V;
                if (-$d2 > min($brbgBL_H, $brbgBL_V) || $flatten) {
                    $p1y = $y00 + $h00 - $bl;
                    $p2y = $y00 + $h00 - $bl;
                }
                if (-$d2 > min($brbgTL_H, $brbgTL_V) || $flatten) {
                    $p3y = $y00 + $bl;
                    $p4y = $y00 + $bl;
                }

                $shadow .= sprintf('%.3F %.3F l ', ($p3x) * _MPDFK, ($this->h - ($p3y)) * _MPDFK);
                $patch_array[5]['f'] = 2;
                $patch_array[5]['points'] = array($p2x, $p2y,
                    $p3x, $p3y, $p3x, $p3y, $p3x, $p3y,
                    $p4c1x, $p4y, $p4x, $p4y, $p4x, $p4y,
                    $p1x, $p1y);
                $patch_array[5]['colors'] = array($col1, $col2);

                // TOP LEFT corner
                $p1x = $x00 + $bl;        // control points only matches p3 preceding
                $p1y = $y00 + $d1 + $brbgTL_V;
                $p1c2y = $p1y - ($d2 + $brbgTL_V) * $mag;
                $p2x = $x00;            // control point only matches p4 preceding
                $p2y = $y00 + $d1 + $brbgTL_V;
                $p2c2y = $p2y - ($d1 + $brbgTL_V) * $mag;
                $p3x = $x00 + $d1 + $brbgTL_H;
                $p3c1x = $p3x - ($d1 + $brbgTL_H) * $mag;
                $p3y = $y00;
                $p3c2y = $p3y + $bl / 2;
                $p4x = $x00 + $d1 + $brbgTL_H;
                $p4c2x = $p4x - ($d2 + $brbgTL_H) * $mag;
                $p4y = $y00 + $bl;

                if (-$d2 > min($brbgTL_H, $brbgTL_V) || $flatten) {
                    $p1y = $y00 + $bl;
                    $p1c2y = $p1y;
                    $p2y = $y00 + $bl;
                    $p2c2y = $p2y - $bl * $mag2;
                    $p3x = $x00 + $bl;
                    $p3c1x = $p3x - $bl * $mag2;
                    $p4x = $x00 + $bl;
                    $p4c2x = $p4x;
                }

                $shadow .= sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', ($p1x) * _MPDFK, ($this->h - ($p1c2y)) * _MPDFK, ($p4c2x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK, ($p4x) * _MPDFK, ($this->h - ($p4y)) * _MPDFK);
                $patch_array[6]['f'] = 2;
                $patch_array[6]['points'] = array($p2x, $p2c2y,
                    $p3c1x, $p3y, $p3x, $p3y, $p3x, $p3c2y,
                    $p4x, $p4y, $p4x, $p4y, $p4c2x, $p4y,
                    $p1x, $p1c2y);
                $patch_array[6]['colors'] = array($col2, $col1);


                // TOP - joins on the right (C3-C4 of previous): f = 2
                $p1x = $x00 + $d1 + $brbgTL_H;    // control point only matches p3 preceding
                $p1y = $y00;
                $p2x = $x00 + $d1 + $brbgTL_H;    // control point only matches p4 preceding
                $p2y = $y00 + $bl;
                $p3x = $x00 + $w00 - $d1 - $brbgTR_H;
                $p3y = $y00 + $bl;
                $p4x = $x00 + $w00 - $d1 - $brbgTR_H;
                $p4y = $y00;
                $p4c1y = $p4y + $bl / 2;
                if (-$d2 > min($brbgTL_H, $brbgTL_V) || $flatten) {
                    $p1x = $x00 + $bl;
                    $p2x = $x00 + $bl;
                }
                if (-$d2 > min($brbgTR_H, $brbgTR_V) || $flatten) {
                    $p3x = $x00 + $w00 - $bl;
                    $p4x = $x00 + $w00 - $bl;
                }

                $shadow .= sprintf('%.3F %.3F l ', ($p3x) * _MPDFK, ($this->h - ($p3y)) * _MPDFK);
                $patch_array[7]['f'] = 2;
                $patch_array[7]['points'] = array($p2x, $p2y,
                    $p3x, $p3y, $p3x, $p3y, $p3x, $p3y,
                    $p4x, $p4c1y, $p4x, $p4y, $p4x, $p4y,
                    $p1x, $p1y);
                $patch_array[7]['colors'] = array($col1, $col2);

                $shadow .= ' h f Q ' . "\n";    // Close path and Fill the inner solid shadow

                if ($bl) $shadow .= $this->grad->CoonsPatchMesh($x00, $y00, $w00, $h00, $patch_array, $x00, $x00 + $w00, $y00, $y00 + $h00, $colspace, true);

                if ($sh['x'] || $sh['y']) $shadow .= ' Q' . "\n";    // Shadow Offset
                $shadow .= ' Q' . "\n";    // Ends path no-op & Sets the clipping path

            }
        }

        $s .= ' W n ';    // Ends path no-op & Sets the clipping path

        if ($this->blk[$blvl]['bgcolor']) {
            $this->pageBackgrounds[$blvl][] = array('x' => $x0, 'y' => $y0, 'w' => $w, 'h' => $h, 'col' => $this->blk[$blvl]['bgcolorarray'], 'clippath' => $s, 'visibility' => $this->visibility, 'shadow' => $shadow, 'z-index' => $this->current_layer);    // mPDF 5.6.01
        } else if ($shadow) {
            $this->pageBackgrounds[$blvl][] = array('shadowonly' => true, 'col' => '', 'clippath' => '', 'visibility' => $this->visibility, 'shadow' => $shadow, 'z-index' => $this->current_layer);    // mPDF 5.6.01
        }

        /*-- BACKGROUNDS --*/
        if (isset($this->blk[$blvl]['gradient'])) {
            $g = $this->grad->parseBackgroundGradient($this->blk[$blvl]['gradient']);
            if ($g) {
                $gx = $x0;
                $gy = $y0;
                $this->pageBackgrounds[$blvl][] = array('gradient' => true, 'x' => $gx, 'y' => $gy, 'w' => $w, 'h' => $h, 'gradtype' => $g['type'], 'stops' => $g['stops'], 'colorspace' => $g['colorspace'], 'coords' => $g['coords'], 'extend' => $g['extend'], 'clippath' => $s, 'visibility' => $this->visibility, 'z-index' => $this->current_layer);    // mPDF 5.6.01
            }
        }
        if (isset($this->blk[$blvl]['background-image'])) {
            if ($this->blk[$blvl]['background-image']['gradient'] && preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $this->blk[$blvl]['background-image']['gradient'])) {
                $g = $this->grad->parseMozGradient($this->blk[$blvl]['background-image']['gradient']);
                if ($g) {
                    $gx = $x0;
                    $gy = $y0;
                    // mPDF 5.6.11
                    // origin specifies the background-positioning-area (bpa)
                    if ($this->blk[$blvl]['background-image']['origin'] == 'padding-box') {
                        $gx += $this->blk[$blvl]['border_left']['w'];
                        $w -= ($this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['border_right']['w']);
                        if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
                            $gy += $this->blk[$blvl]['border_top']['w'];
                        }
                        if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
                            $gy1 = $y1 - $this->blk[$blvl]['border_bottom']['w'];
                        } else {
                            $gy1 = $y1;
                        }
                        $h = $gy1 - $gy;
                    } else if ($this->blk[$blvl]['background-image']['origin'] == 'content-box') {
                        $gx += $this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['padding_left'];
                        $w -= ($this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['padding_left'] + $this->blk[$blvl]['border_right']['w'] + $this->blk[$blvl]['padding_right']);
                        if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
                            $gy += $this->blk[$blvl]['border_top']['w'] + $this->blk[$blvl]['padding_top'];
                        }
                        if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
                            $gy1 = $y1 - ($this->blk[$blvl]['border_bottom']['w'] + $this->blk[$blvl]['padding_bottom']);
                        } else {
                            $gy1 = $y1 - $this->blk[$blvl]['padding_bottom'];
                        }
                        $h = $gy1 - $gy;
                    }

                    if (isset($this->blk[$blvl]['background-image']['size']['w']) && $this->blk[$blvl]['background-image']['size']['w']) {
                        $size = $this->blk[$blvl]['background-image']['size'];
                        if ($size['w'] != 'contain' && $size['w'] != 'cover') {
                            if (stristr($size['w'], '%')) {
                                $size['w'] += 0;
                                $size['w'] /= 100;
                                $w *= $size['w'];
                            } else if ($size['w'] != 'auto') {
                                $w = $size['w'];
                            }
                            if (stristr($size['h'], '%')) {
                                $size['h'] += 0;
                                $size['h'] /= 100;
                                $h *= $size['h'];
                            } else if ($size['h'] != 'auto') {
                                $h = $size['h'];
                            }
                        }
                    }
                    $this->pageBackgrounds[$blvl][] = array('gradient' => true, 'x' => $gx, 'y' => $gy, 'w' => $w, 'h' => $h, 'gradtype' => $g['type'], 'stops' => $g['stops'], 'colorspace' => $g['colorspace'], 'coords' => $g['coords'], 'extend' => $g['extend'], 'clippath' => $s, 'visibility' => $this->visibility, 'z-index' => $this->current_layer);    // mPDF 5.6.01
                }
            } else {
                $image_id = $this->blk[$blvl]['background-image']['image_id'];
                $orig_w = $this->blk[$blvl]['background-image']['orig_w'];
                $orig_h = $this->blk[$blvl]['background-image']['orig_h'];
                $x_pos = $this->blk[$blvl]['background-image']['x_pos'];
                $y_pos = $this->blk[$blvl]['background-image']['y_pos'];
                $x_repeat = $this->blk[$blvl]['background-image']['x_repeat'];
                $y_repeat = $this->blk[$blvl]['background-image']['y_repeat'];
                $resize = $this->blk[$blvl]['background-image']['resize'];
                $opacity = $this->blk[$blvl]['background-image']['opacity'];
                $itype = $this->blk[$blvl]['background-image']['itype'];
                $size = $this->blk[$blvl]['background-image']['size'];    // mPDF 5.6.10
                // mPDF 5.6.10
                // origin specifies the background-positioning-area (bpa)
                $bpa = array('x' => $x0, 'y' => $y0, 'w' => $w, 'h' => $h);
                if ($this->blk[$blvl]['background-image']['origin'] == 'padding-box') {
                    $bpa['x'] = $x0 + $this->blk[$blvl]['border_left']['w'];
                    $bpa['w'] = $w - ($this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['border_right']['w']);
                    if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
                        $bpa['y'] = $y0 + $this->blk[$blvl]['border_top']['w'];
                    } else {
                        $bpa['y'] = $y0;
                    }
                    if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
                        $bpay = $y1 - $this->blk[$blvl]['border_bottom']['w'];
                    } else {
                        $bpay = $y1;
                    }
                    $bpa['h'] = $bpay - $bpa['y'];
                } // mPDF 5.6.09
                else if ($this->blk[$blvl]['background-image']['origin'] == 'content-box') {
                    $bpa['x'] = $x0 + $this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['padding_left'];
                    $bpa['w'] = $w - ($this->blk[$blvl]['border_left']['w'] + $this->blk[$blvl]['padding_left'] + $this->blk[$blvl]['border_right']['w'] + $this->blk[$blvl]['padding_right']);
                    if ($this->blk[$blvl]['border_top'] && $divider != 'pagetop' && !$continuingpage) {
                        $bpa['y'] = $y0 + $this->blk[$blvl]['border_top']['w'] + $this->blk[$blvl]['padding_top'];
                    } else {
                        $bpa['y'] = $y0 + $this->blk[$blvl]['padding_top'];
                    }
                    if ($this->blk[$blvl]['border_bottom'] && $blockstate != 1 && $divider != 'pagebottom') {
                        $bpay = $y1 - ($this->blk[$blvl]['border_bottom']['w'] + $this->blk[$blvl]['padding_bottom']);
                    } else {
                        $bpay = $y1 - $this->blk[$blvl]['padding_bottom'];
                    }
                    $bpa['h'] = $bpay - $bpa['y'];
                }
                $this->pageBackgrounds[$blvl][] = array('x' => $x0, 'y' => $y0, 'w' => $w, 'h' => $h, 'image_id' => $image_id, 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $x_pos, 'y_pos' => $y_pos, 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'clippath' => $s, 'resize' => $resize, 'opacity' => $opacity, 'itype' => $itype, 'visibility' => $this->visibility, 'z-index' => $this->current_layer, 'size' => $size, 'bpa' => $bpa);    // mPDF 5.6.01  5.6.10
            }
        }
        /*-- END BACKGROUNDS --*/

        // Float DIV
        $this->blk[$blvl]['bb_painted'][$this->page] = true;

    }

    function GetStringWidth($s, $addSubset = true)
    {
        //Get width of a string in the current font
        $s = (string)$s;
        $cw = &$this->CurrentFont['cw'];
        $w = 0;
        $kerning = 0;
        $lastchar = 0;
        $nb_carac = 0;
        $nb_spaces = 0;
        // mPDF ITERATION
        if ($this->iterationCounter) $s = preg_replace('/{iteration ([a-zA-Z0-9_]+)}/', '\\1', $s);

        if (!$this->usingCoreFont) {
            $s = str_replace("\xc2\xad", '', $s);
            $unicode = $this->UTF8StringToArray($s, $addSubset);
            if ($this->minwSpacing || $this->fixedlSpacing) {
                $nb_carac = count($unicode);
                $nb_spaces = mb_substr_count($s, ' ', $this->mb_enc);
            }
            /*-- CJK-FONTS --*/
            if ($this->CurrentFont['type'] == 'Type0') {    // CJK Adobe fonts
                foreach ($unicode as $char) {
                    if (isset($cw[$char])) {
                        $w += $cw[$char];
                    } elseif (isset($this->CurrentFont['MissingWidth'])) {
                        $w += $this->CurrentFont['MissingWidth'];
                    } else {
                        $w += 500;
                    }
                }
            } else {
                /*-- END CJK-FONTS --*/
                foreach ($unicode as $char) {
                    if ($this->S && isset($this->upperCase[$char])) {
                        $charw = $this->_getCharWidth($cw, $this->upperCase[$char]);
                        if ($charw !== false) {
                            $charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
                            $w += $charw;
                        } elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
                            $w += $this->CurrentFont['desc']['MissingWidth'];
                        } elseif (isset($this->CurrentFont['MissingWidth'])) {
                            $w += $this->CurrentFont['MissingWidth'];
                        } else {
                            $w += 500;
                        }
                    } else {
                        $charw = $this->_getCharWidth($cw, $char);
                        if ($charw !== false) {
                            $w += $charw;
                        } elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
                            $w += $this->CurrentFont['desc']['MissingWidth'];
                        } elseif (isset($this->CurrentFont['MissingWidth'])) {
                            $w += $this->CurrentFont['MissingWidth'];
                        } else {
                            $w += 500;
                        }
                        if ($this->kerning && $this->useKerning && $lastchar) {
                            if (isset($this->CurrentFont['kerninfo'][$lastchar][$char])) {
                                $kerning += $this->CurrentFont['kerninfo'][$lastchar][$char];
                            }
                        }
                        $lastchar = $char;
                    }
                }
            }    // *CJK-FONTS*

        } else {
            if ($this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats') {
                $s = str_replace(chr(173), '', $s);
            }
            $nb_carac = $l = strlen($s);
            if ($this->minwSpacing || $this->fixedlSpacing) {
                $nb_spaces = substr_count($s, ' ');
            }
            for ($i = 0; $i < $l; $i++) {
                if ($this->S && isset($this->upperCase[ord($s[$i])])) {
                    $charw = $cw[chr($this->upperCase[ord($s[$i])])];
                    if ($charw !== false) {
                        $charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
                        $w += $charw;
                    }
                } else if (isset($cw[$s[$i]])) {
                    $w += $cw[$s[$i]];
                } else if (isset($cw[ord($s[$i])])) {
                    $w += $cw[ord($s[$i])];
                }
                if ($this->kerning && $this->useKerning && $i > 0) {
                    if (isset($this->CurrentFont['kerninfo'][$s[($i - 1)]][$s[$i]])) {
                        $kerning += $this->CurrentFont['kerninfo'][$s[($i - 1)]][$s[$i]];
                    }
                }
            }
        }
        unset($cw);
        if ($this->kerning && $this->useKerning) {
            $w += $kerning;
        }
        $w *= ($this->FontSize / 1000);
        $w += (($nb_carac + $nb_spaces) * $this->fixedlSpacing) + ($nb_spaces * $this->minwSpacing);
        return ($w);
    }

    /*-- END HTML-CSS --*/

//=============================================================
//=============================================================
//=============================================================
//=============================================================
//=============================================================

    function UTF8StringToArray($str, $addSubset = true)
    {
        $out = array();
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $uni = -1;
            $h = ord($str[$i]);
            if ($h <= 0x7F)
                $uni = $h;
            elseif ($h >= 0xC2) {
                if (($h <= 0xDF) && ($i < $len - 1))
                    $uni = ($h & 0x1F) << 6 | (ord($str[++$i]) & 0x3F);
                elseif (($h <= 0xEF) && ($i < $len - 2))
                    $uni = ($h & 0x0F) << 12 | (ord($str[++$i]) & 0x3F) << 6 | (ord($str[++$i]) & 0x3F);
                elseif (($h <= 0xF4) && ($i < $len - 3))
                    $uni = ($h & 0x0F) << 18 | (ord($str[++$i]) & 0x3F) << 12 | (ord($str[++$i]) & 0x3F) << 6 | (ord($str[++$i]) & 0x3F);
            }
            if ($uni >= 0) {
                $out[] = $uni;
                if ($addSubset && isset($this->CurrentFont['subset'])) {
                    $this->CurrentFont['subset'][$uni] = $uni;
                }
            }
        }
        return $out;
    }

    function _getCharWidth(&$cw, $u, $isdef = true)
    {
        if ($u == 0) {
            $w = false;
        } else {
            $w = (ord($cw[$u * 2]) << 8) + ord($cw[$u * 2 + 1]);
        }
        if ($w == 65535) {
            return 0;
        } else if ($w) {
            return $w;
        } else if ($isdef) {
            return false;
        } else {
            return 0;
        }
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '', $currentx = 0, $lcpaddingL = 0, $lcpaddingR = 0, $valign = 'M', $spanfill = 0, $abovefont = 0, $belowfont = 0, $exactWidth = false)
    {
        //Output a cell
        // Expects input to be mb_encoded if necessary and RTL reversed
        // NON_BREAKING SPACE
        if ($this->usingCoreFont) {
            $txt = str_replace(chr(160), chr(32), $txt);
        } else {
            $txt = str_replace(chr(194) . chr(160), chr(32), $txt);
        }

        $oldcolumn = $this->CurrCol;
        // Automatic page break
        // Allows PAGE-BREAK-AFTER = avoid to work
        if (!$this->tableLevel && (($this->y + $this->divheight > $this->PageBreakTrigger) || ($this->y + $h > $this->PageBreakTrigger) ||
                ($this->y + ($h * 2) + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['margin_bottom'] > $this->PageBreakTrigger && $this->blk[$this->blklvl]['page_break_after_avoid'])) and !$this->InFooter and $this->AcceptPageBreak()) {    // mPDF 5.7.2
            $x = $this->x;//Current X position


            // WORD SPACING
            $ws = $this->ws;//Word Spacing
            $charspacing = $this->charspacing;//Character Spacing
            $this->ResetSpacing();

            $this->AddPage($this->CurOrientation);
            // Added to correct for OddEven Margins
            $x += $this->MarginCorrection;
            if ($currentx) {
                $currentx += $this->MarginCorrection;
            }
            $this->x = $x;
            // WORD SPACING
            $this->SetSpacing($charspacing, $ws);
        }

        // Test: to put line through centre of cell: $this->Line($this->x,$this->y+($h/2),$this->x+50,$this->y+($h/2));

        /*-- COLUMNS --*/
        // COLS
        // COLUMN CHANGE
        if ($this->CurrCol != $oldcolumn) {
            if ($currentx) {
                $currentx += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
            }
            $this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
        }

        // COLUMNS Update/overwrite the lowest bottom of printing y value for a column
        if ($this->ColActive) {
            if ($h) {
                $this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $h;
            } else {
                $this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $this->divheight;
            }
        }
        /*-- END COLUMNS --*/

        // KEEP BLOCK TOGETHER Update/overwrite the lowest bottom of printing y value on first page
        if ($this->keep_block_together) {
            if ($h) {
                $this->ktBlock[$this->page]['bottom_margin'] = $this->y + $h;
            }
//		else { $this->ktBlock[$this->page]['bottom_margin'] = $this->y+$this->divheight; }
        }

        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        if ($fill == 1 && $this->FillColor) {
            if ((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor']) || $this->keep_block_together) {
                $s .= $this->FillColor . ' ';
            }
            $this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
        }


        $boxtop = $this->y;
        $boxheight = $h;
        $boxbottom = $this->y + $h;

        if ($txt != '') {
            // FONT SIZE - this determines the baseline caculation
            if ($this->linemaxfontsize && !$this->processingHeader) {
                $bfs = $this->linemaxfontsize;
            } else {
                $bfs = $this->FontSize;
            }
            //Calculate baseline Superscript and Subscript Y coordinate adjustment
            $bfx = $this->baselineC;
            $baseline = $bfx * $bfs;
            // mPDF 5.7.3  inline text-decoration parameters
            if ($this->SUP) {
                $baseline -= $this->textparam['text-baseline'];
            }    // mPDF 5.7.1
            else if ($this->SUB) {
                $baseline -= $this->textparam['text-baseline'];
            }    // mPDF 5.7.1
            else if ($this->bullet) {
                $baseline += ($bfx - 0.7) * $this->FontSize;
            }

            // Vertical align (for Images)
            if ($abovefont || $belowfont) {    // from flowing block - valign always M
                $va = $abovefont + (0.5 * $bfs);
            } else if ($this->lineheight_correction) {
                if ($valign == 'T') {
                    $va = (0.5 * $bfs * $this->lineheight_correction);
                } else if ($valign == 'B') {
                    $va = $h - (0.5 * $bfs * $this->lineheight_correction);
                } else {
                    $va = 0.5 * $h;
                }    // Middle
            } else {
                if ($valign == 'T') {
                    $va = (0.5 * $bfs * $this->default_lineheight_correction);
                } else if ($valign == 'B') {
                    $va = $h - (0.5 * $bfs * $this->default_lineheight_correction);
                } else {
                    $va = 0.5 * $h;
                }    // Middle
            }

            // ONLY SET THESE IF WANT TO CONFINE BORDER +/- FILL TO FIT FONTSIZE - NOT FULL CELL AS IS ORIGINAL FUNCTION
            // spanfill or spanborder are set in FlowingBlock functions
            if ($spanfill || !empty($this->spanborddet) || $link != '') {
                $exth = 0.2;    // Add to fontsize to increase height of background / link / border
                $boxtop = $this->y + $baseline + $va - ($this->FontSize * (1 + $exth / 2) * (0.5 + $bfx));
                $boxheight = $this->FontSize * (1 + $exth);
                $boxbottom = $boxtop + $boxheight;
            }
        }

        $bbw = $tbw = $lbw = $rbw = 0;    // Border widths
        if (!empty($this->spanborddet)) {
            if (!isset($this->spanborddet['B'])) {
                $this->spanborddet['B'] = array('s' => 0, 'style' => '', 'w' => 0);
            }
            if (!isset($this->spanborddet['T'])) {
                $this->spanborddet['T'] = array('s' => 0, 'style' => '', 'w' => 0);
            }
            if (!isset($this->spanborddet['L'])) {
                $this->spanborddet['L'] = array('s' => 0, 'style' => '', 'w' => 0);
            }
            if (!isset($this->spanborddet['R'])) {
                $this->spanborddet['R'] = array('s' => 0, 'style' => '', 'w' => 0);
            }
            $bbw = $this->spanborddet['B']['w'];
            $tbw = $this->spanborddet['T']['w'];
            $lbw = $this->spanborddet['L']['w'];
            $rbw = $this->spanborddet['R']['w'];
        }
        if ($fill == 1 || $border == 1 || !empty($this->spanborddet)) {
            if (!empty($this->spanborddet)) {
                if ($fill == 1) {
                    $s .= sprintf('%.3F %.3F %.3F %.3F re f ', ($this->x - $lbw) * _MPDFK, ($this->h - $boxtop + $tbw) * _MPDFK, ($w + $lbw + $rbw) * _MPDFK, (-$boxheight - $tbw - $bbw) * _MPDFK);
                }
                $s .= ' q ';
                $dashon = 3;
                $dashoff = 3.5;
                $dot = 2.5;
                if ($tbw) {
                    $short = 0;
                    if ($this->spanborddet['T']['style'] == 'dashed') {
                        $s .= sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $tbw * $dashon * _MPDFK, $tbw * $dashoff * _MPDFK);
                    } else if ($this->spanborddet['T']['style'] == 'dotted') {
                        $s .= sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $tbw * $dot * _MPDFK, -$tbw / 2 * _MPDFK);
                        $short = $tbw / 2;
                    } else {
                        $s .= ' 0 j 0 J [] 0 d ';
                    }
                    $c = $this->SetDColor($this->spanborddet['T']['c'], true);
                    if ($this->spanborddet['T']['style'] == 'double') {
                        $s .= sprintf(' %s %.3F w ', $c, $tbw / 3 * _MPDFK);
                        $xadj = $xadj2 = 0;
                        if ($this->spanborddet['L']['style'] == 'double') {
                            $xadj = $this->spanborddet['L']['w'] * 2 / 3;
                        }
                        if ($this->spanborddet['R']['style'] == 'double') {
                            $xadj2 = $this->spanborddet['R']['w'] * 2 / 3;
                        }
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $boxtop + $tbw * 5 / 6) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $boxtop + $tbw * 5 / 6) * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw + $xadj) * _MPDFK, ($this->h - $boxtop + $tbw / 6) * _MPDFK, ($this->x + $w + $rbw - $short - $xadj2) * _MPDFK, ($this->h - $boxtop + $tbw / 6) * _MPDFK);
                    } else {
                        $s .= sprintf(' %s %.3F w ', $c, $tbw * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $boxtop + $tbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $boxtop + $tbw / 2) * _MPDFK);
                    }
                }
                if ($bbw) {
                    $short = 0;
                    if ($this->spanborddet['B']['style'] == 'dashed') {
                        $s .= sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $bbw * $dashon * _MPDFK, $bbw * $dashoff * _MPDFK);
                    } else if ($this->spanborddet['B']['style'] == 'dotted') {
                        $s .= sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $bbw * $dot * _MPDFK, -$bbw / 2 * _MPDFK);
                        $short = $bbw / 2;
                    } else {
                        $s .= ' 0 j 0 J [] 0 d ';
                    }
                    $c = $this->SetDColor($this->spanborddet['B']['c'], true);
                    if ($this->spanborddet['B']['style'] == 'double') {
                        $s .= sprintf(' %s %.3F w ', $c, $bbw / 3 * _MPDFK);
                        $xadj = $xadj2 = 0;
                        if ($this->spanborddet['L']['style'] == 'double') {
                            $xadj = $this->spanborddet['L']['w'] * 2 / 3;
                        }
                        if ($this->spanborddet['R']['style'] == 'double') {
                            $xadj2 = $this->spanborddet['R']['w'] * 2 / 3;
                        }
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw + $xadj) * _MPDFK, ($this->h - $boxbottom - $bbw / 6) * _MPDFK, ($this->x + $w + $rbw - $short - $xadj2) * _MPDFK, ($this->h - $boxbottom - $bbw / 6) * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $boxbottom - $bbw * 5 / 6) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $boxbottom - $bbw * 5 / 6) * _MPDFK);
                    } else {
                        $s .= sprintf(' %s %.3F w ', $c, $bbw * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $boxbottom - $bbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $boxbottom - $bbw / 2) * _MPDFK);
                    }
                }
                if ($lbw) {
                    $short = 0;
                    if ($this->spanborddet['L']['style'] == 'dashed') {
                        $s .= sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $lbw * $dashon * _MPDFK, $lbw * $dashoff * _MPDFK);
                    } else if ($this->spanborddet['L']['style'] == 'dotted') {
                        $s .= sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $lbw * $dot * _MPDFK, -$lbw / 2 * _MPDFK);
                        $short = $lbw / 2;
                    } else {
                        $s .= ' 0 j 0 J [] 0 d ';
                    }
                    $c = $this->SetDColor($this->spanborddet['L']['c'], true);
                    if ($this->spanborddet['L']['style'] == 'double') {
                        $s .= sprintf(' %s %.3F w ', $c, $lbw / 3 * _MPDFK);
                        $yadj = $yadj2 = 0;
                        if ($this->spanborddet['T']['style'] == 'double') {
                            $yadj = $this->spanborddet['T']['w'] * 2 / 3;
                        }
                        if ($this->spanborddet['B']['style'] == 'double') {
                            $yadj2 = $this->spanborddet['B']['w'] * 2 / 3;
                        }
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw / 6) * _MPDFK, ($this->h - $boxtop + $tbw - $yadj) * _MPDFK, ($this->x - $lbw / 6) * _MPDFK, ($this->h - $boxbottom - $bbw + $short + $yadj2) * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw * 5 / 6) * _MPDFK, ($this->h - $boxtop + $tbw) * _MPDFK, ($this->x - $lbw * 5 / 6) * _MPDFK, ($this->h - $boxbottom - $bbw + $short) * _MPDFK);
                    } else {
                        $s .= sprintf(' %s %.3F w ', $c, $lbw * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw / 2) * _MPDFK, ($this->h - $boxtop + $tbw) * _MPDFK, ($this->x - $lbw / 2) * _MPDFK, ($this->h - $boxbottom - $bbw + $short) * _MPDFK);
                    }
                }
                if ($rbw) {
                    $short = 0;
                    if ($this->spanborddet['R']['style'] == 'dashed') {
                        $s .= sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $rbw * $dashon * _MPDFK, $rbw * $dashoff * _MPDFK);
                    } else if ($this->spanborddet['R']['style'] == 'dotted') {
                        $s .= sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $rbw * $dot * _MPDFK, -$rbw / 2 * _MPDFK);
                        $short = $rbw / 2;
                    } else {
                        $s .= ' 0 j 0 J [] 0 d ';
                    }
                    $c = $this->SetDColor($this->spanborddet['R']['c'], true);
                    if ($this->spanborddet['R']['style'] == 'double') {
                        $s .= sprintf(' %s %.3F w ', $c, $rbw / 3 * _MPDFK);
                        $yadj = $yadj2 = 0;
                        if ($this->spanborddet['T']['style'] == 'double') {
                            $yadj = $this->spanborddet['T']['w'] * 2 / 3;
                        }
                        if ($this->spanborddet['B']['style'] == 'double') {
                            $yadj2 = $this->spanborddet['B']['w'] * 2 / 3;
                        }
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw / 6) * _MPDFK, ($this->h - $boxtop + $tbw - $yadj) * _MPDFK, ($this->x + $w + $rbw / 6) * _MPDFK, ($this->h - $boxbottom - $bbw + $short + $yadj2) * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw * 5 / 6) * _MPDFK, ($this->h - $boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw * 5 / 6) * _MPDFK, ($this->h - $boxbottom - $bbw + $short) * _MPDFK);
                    } else {
                        $s .= sprintf(' %s %.3F w ', $c, $rbw * _MPDFK);
                        $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $boxbottom - $bbw + $short) * _MPDFK);
                    }
                }
                $s .= ' Q ';
            } else {
                if ($fill == 1) $op = ($border == 1) ? 'B' : 'f';
                else $op = 'S';
                $s .= sprintf('%.3F %.3F %.3F %.3F re %s ', $this->x * _MPDFK, ($this->h - $boxtop) * _MPDFK, $w * _MPDFK, -$boxheight * _MPDFK, $op);
            }
        }

        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - $boxtop) * _MPDFK, $x * _MPDFK, ($this->h - ($boxbottom)) * _MPDFK);
            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - $boxtop) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - $boxtop) * _MPDFK);
            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', ($x + $w) * _MPDFK, ($this->h - $boxtop) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - ($boxbottom)) * _MPDFK);
            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - ($boxbottom)) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - ($boxbottom)) * _MPDFK);
        }

        if ($txt != '') {
            if ($exactWidth)
                $stringWidth = $w;
            else
                $stringWidth = $this->GetStringWidth($txt) + ($this->charspacing * mb_strlen($txt, $this->mb_enc) / _MPDFK)
                    + ($this->ws * mb_substr_count($txt, ' ', $this->mb_enc) / _MPDFK);

            // Set x OFFSET FOR PRINTING
            if ($align == 'R') {
                $dx = $w - $this->cMarginR - $stringWidth - $lcpaddingR;
            } elseif ($align == 'C') {
                $dx = (($w - $stringWidth) / 2);
            } elseif ($align == 'L' or $align == 'J') $dx = $this->cMarginL + $lcpaddingL;
            else $dx = 0;

            if ($this->ColorFlag) $s .= 'q ' . $this->TextColor . ' ';

            // OUTLINE
            if ($this->textparam['outline-s'] && !$this->S) {    // mPDF 5.6.07
                $s .= ' ' . sprintf('%.3F w', $this->LineWidth * _MPDFK) . ' ';
                $s .= " $this->DrawColor ";
                $s .= " 2 Tr ";
            } else if ($this->falseBoldWeight && strpos($this->ReqFontStyle, "B") !== false && strpos($this->FontStyle, "B") === false && !$this->S) {    // can't use together with OUTLINE or Small Caps
                $s .= ' 2 Tr 1 J 1 j ';
                $s .= ' ' . sprintf('%.3F w', ($this->FontSize / 130) * _MPDFK * $this->falseBoldWeight) . ' ';
                $tc = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
                if ($this->FillColor != $tc) {
                    $s .= ' ' . $tc . ' ';
                }        // stroke (outline) = same colour as text(fill)
            } else {
                $s .= " 0 Tr ";
            }    // mPDF 5.6.07

            if (strpos($this->ReqFontStyle, "I") !== false && strpos($this->FontStyle, "I") === false) {    // Artificial italic
                $aix = '1 0 0.261799 1 %.3F %.3F Tm ';
            } else {
                $aix = '%.3F %.3F Td ';
            }

            // THE TEXT
            $sub = '';
            $this->CurrentFont['used'] = true;

            // WORD SPACING
            // IF multibyte - Tw has no effect - need to use alternative method - do word spacing using an adjustment before each space
            if ($this->ws && !$this->usingCoreFont && !$this->CurrentFont['sip'] && !$this->CurrentFont['smp'] && !$this->S) {
                $sub .= ' BT 0 Tw ET ';
                if ($this->kerning && $this->useKerning) {
                    $sub .= $this->_kern($txt, 'MBTw', $aix, ($this->x + $dx), ($this->y + $baseline + $va));
                } else {
                    $space = " ";
                    //Convert string to UTF-16BE without BOM
                    $space = $this->UTF8ToUTF16BE($space, false);
                    $space = $this->_escape($space);
                    $sub .= sprintf('BT ' . $aix, ($this->x + $dx) * _MPDFK, ($this->h - ($this->y + $baseline + $va)) * _MPDFK);
                    $t = explode(' ', $txt);
                    $sub .= sprintf(' %.3F Tc [', $this->charspacing);
                    $numt = count($t);
                    for ($i = 0; $i < $numt; $i++) {
                        $tx = $t[$i];
                        //Convert string to UTF-16BE without BOM
                        $tx = $this->UTF8ToUTF16BE($tx, false);
                        $tx = $this->_escape($tx);
                        $sub .= sprintf('(%s) ', $tx);
                        if (($i + 1) < $numt) {
                            $adj = -($this->ws) * 1000 / $this->FontSizePt;
                            $sub .= sprintf('%d(%s) ', $adj, $space);
                        }
                    }
                    $sub .= '] TJ ';
                    $sub .= ' ET';
                }
            } else {
                $txt2 = $txt;
                if ($this->CurrentFont['type'] == 'TTF' && ($this->CurrentFont['sip'] || $this->CurrentFont['smp'])) {
                    if ($this->S) {
                        $sub .= $this->_smallCaps($txt2, 'SIPSMP', $aix, $dx, _MPDFK, $baseline, $va);
                    } else {
                        $txt2 = $this->UTF8toSubset($txt2);
                        $sub .= sprintf('BT ' . $aix . ' %s Tj ET', ($this->x + $dx) * _MPDFK, ($this->h - ($this->y + $baseline + $va)) * _MPDFK, $txt2);
                    }
                } else {
                    if ($this->S) {
                        $sub .= $this->_smallCaps($txt2, '', $aix, $dx, _MPDFK, $baseline, $va);
                    } else if ($this->kerning && $this->useKerning) {
                        $sub .= $this->_kern($txt2, '', $aix, ($this->x + $dx), ($this->y + $baseline + $va));
                    } else {
                        if (!$this->usingCoreFont) {
                            $txt2 = $this->UTF8ToUTF16BE($txt2, false);
                        }
                        $txt2 = $this->_escape($txt2);
                        $sub .= sprintf('BT ' . $aix . ' (%s) Tj ET', ($this->x + $dx) * _MPDFK, ($this->h - ($this->y + $baseline + $va)) * _MPDFK, $txt2);
                    }
                }
            }
            // UNDERLINE
            if ($this->U) {
                // mPDF 5.7.3  inline text-decoration parameters
                $c = $this->textparam['u-decoration']['color'];
                if ($this->FillColor != $c) {
                    $sub .= ' ' . $c . ' ';
                }
                // mPDF 5.7.3  inline text-decoration parameters
                $decorationfontkey = $this->textparam['u-decoration']['fontkey'];
                $decorationfontsize = $this->textparam['u-decoration']['fontsize'];
                if (isset($this->fonts[$decorationfontkey]['up'])) {
                    $up = $this->fonts[$decorationfontkey]['up'];
                } else {
                    $up = -100;
                }
                $adjusty = (-$up / 1000 * $decorationfontsize);
                if (isset($this->fonts[$decorationfontkey]['ut'])) {
                    $ut = $this->fonts[$decorationfontkey]['ut'] / 1000 * $decorationfontsize;
                } else {
                    $ut = 60 / 1000 * $decorationfontsize;
                }
                $ubaseline = $this->baselineC * $bfs - $this->textparam['u-decoration']['baseline'];
                $olw = $this->LineWidth;
                $sub .= ' ' . (sprintf(' %.3F w 0 j 0 J ', $ut * _MPDFK));
                $sub .= ' ' . $this->_dounderline($this->x + $dx, $this->y + $ubaseline + $va + $adjusty, $txt, $OTLdata, $textvar);
                $sub .= ' ' . (sprintf(' %.3F w 2 j 2 J ', $olw * _MPDFK));
                if ($this->FillColor != $c) {
                    $sub .= ' ' . $this->FillColor . ' ';
                }
            }

            // STRIKETHROUGH
            if ($this->strike) {
                // mPDF 5.7.3  inline text-decoration parameters
                $c = $this->textparam['s-decoration']['color'];
                if ($this->FillColor != $c) {
                    $sub .= ' ' . $c . ' ';
                }
                // mPDF 5.7.3  inline text-decoration parameters
                $decorationfontkey = $this->textparam['s-decoration']['fontkey'];
                $decorationfontsize = $this->textparam['s-decoration']['fontsize'];
                //Superscript and Subscript Y coordinate adjustment (now for striked-through texts)
                if (isset($this->fonts[$decorationfontkey]['desc']['CapHeight'])) {
                    $ch = $this->fonts[$decorationfontkey]['desc']['CapHeight'];
                } else {
                    $ch = 700;
                }
                $adjusty = (-$ch / 1000 * $decorationfontsize) * $this->baselineS;
                if (isset($this->fonts[$decorationfontkey]['ut'])) {
                    $ut = $this->fonts[$decorationfontkey]['ut'] / 1000 * $decorationfontsize;
                } else {
                    $ut = 60 / 1000 * $decorationfontsize;
                }
                $sbaseline = $this->baselineC * $bfs - $this->textparam['s-decoration']['baseline'];
                $olw = $this->LineWidth;
                $sub .= ' ' . (sprintf(' %.3F w 0 j 0 J ', $ut * _MPDFK));
                $sub .= ' ' . $this->_dounderline($this->x + $dx, $this->y + $sbaseline + $va + $adjusty, $txt, $OTLdata, $textvar);
                $sub .= ' ' . (sprintf(' %.3F w 2 j 2 J ', $olw * _MPDFK));
                if ($this->FillColor != $c) {
                    $sub .= ' ' . $this->FillColor . ' ';
                }
            }

            // TEXT SHADOW
            if ($this->textshadow) {        // First to process is last in CSS comma separated shadows
                foreach ($this->textshadow AS $ts) {
                    $s .= ' q ';
                    $s .= $this->SetTColor($ts['col'], true) . "\n";
                    if ($ts['col']{0} == 5 && ord($ts['col']{4}) < 100) {    // RGBa
                        $s .= $this->SetAlpha(ord($ts['col']{4}) / 100, 'Normal', true, 'F') . "\n";
                    } else if ($ts['col']{0} == 6 && ord($ts['col']{5}) < 100) {    // CMYKa
                        $s .= $this->SetAlpha(ord($ts['col']{5}) / 100, 'Normal', true, 'F') . "\n";
                    } else if ($ts['col']{0} == 1 && $ts['col']{2} == 1 && ord($ts['col']{3}) < 100) {    // Gray
                        $s .= $this->SetAlpha(ord($ts['col']{3}) / 100, 'Normal', true, 'F') . "\n";
                    }
                    $s .= sprintf(' 1 0 0 1 %.4F %.4F cm', $ts['x'] * _MPDFK, -$ts['y'] * _MPDFK) . "\n";
                    $s .= $sub;
                    $s .= ' Q ';
                }
            }

            $s .= $sub;

            // COLOR
            if ($this->ColorFlag) $s .= ' Q';

            // LINK
            if ($link != '') {
                $this->Link($this->x, $boxtop, $w, $boxheight, $link);
            }
        }
        if ($s) $this->_out($s);

        // WORD SPACING
        if ($this->ws && !$this->usingCoreFont) {
            $this->_out(sprintf('BT %.3F Tc ET', $this->charspacing));
        }
        $this->lasth = $h;
        if (strpos($txt, "\n") !== false) $ln = 1; // cell recognizes \n from <BR> tag
        if ($ln > 0) {
            //Go to next line
            $this->y += $h;
            if ($ln == 1) {
                //Move to next line
                if ($currentx != 0) {
                    $this->x = $currentx;
                } else {
                    $this->x = $this->lMargin;
                }
            }
        } else $this->x += $w;


    }

    function ResetSpacing()
    {
        if ($this->ws != 0) {
            $this->_out('BT 0 Tw ET');
        }
        $this->ws = 0;
        if ($this->charspacing != 0) {
            $this->_out('BT 0 Tc ET');
        }
        $this->charspacing = 0;
    }

    function SetSpacing($cs, $ws)
    {
        if (intval($cs * 1000) == 0) {
            $cs = 0;
        }
        if ($cs) {
            $this->_out(sprintf('BT %.3F Tc ET', $cs));
        } else if ($this->charspacing != 0) {
            $this->_out('BT 0 Tc ET');
        }
        $this->charspacing = $cs;
        if (intval($ws * 1000) == 0) {
            $ws = 0;
        }
        if ($ws) {
            $this->_out(sprintf('BT %.3F Tw ET', $ws));
        } else if ($this->ws != 0) {
            $this->_out('BT 0 Tw ET');
        }
        $this->ws = $ws;
    }

    /*-- HTML-CSS --*/
// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom

    function _kern($txt, $mode, $aix, $x, $y)
    {
        if ($mode == 'MBTw') {    // Multibyte requiring word spacing
            $space = ' ';
            //Convert string to UTF-16BE without BOM
            $space = $this->UTF8ToUTF16BE($space, false);
            $space = $this->_escape($space);
            $s = sprintf(' BT ' . $aix, $x * _MPDFK, ($this->h - $y) * _MPDFK);
            $t = explode(' ', $txt);
            for ($i = 0; $i < count($t); $i++) {
                $tx = $t[$i];

                $tj = '(';
                $unicode = $this->UTF8StringToArray($tx);
                for ($ti = 0; $ti < count($unicode); $ti++) {
                    if ($ti > 0 && isset($this->CurrentFont['kerninfo'][$unicode[($ti - 1)]][$unicode[$ti]])) {
                        $kern = -$this->CurrentFont['kerninfo'][$unicode[($ti - 1)]][$unicode[$ti]];
                        $tj .= sprintf(')%d(', $kern);
                    }
                    $tc = code2utf($unicode[$ti]);
                    $tc = $this->UTF8ToUTF16BE($tc, false);
                    $tj .= $this->_escape($tc);
                }
                $tj .= ')';
                $s .= sprintf(' %.3F Tc [%s] TJ', $this->charspacing, $tj);


                if (($i + 1) < count($t)) {
                    $s .= sprintf(' %.3F Tc (%s) Tj', $this->ws + $this->charspacing, $space);
                }
            }
            $s .= ' ET ';
        } else if (!$this->usingCoreFont) {
            $s = '';
            $tj = '(';
            $unicode = $this->UTF8StringToArray($txt);
            for ($i = 0; $i < count($unicode); $i++) {
                if ($i > 0 && isset($this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]])) {
                    $kern = -$this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]];
                    $tj .= sprintf(')%d(', $kern);
                }
                $tx = code2utf($unicode[$i]);
                $tx = $this->UTF8ToUTF16BE($tx, false);
                $tj .= $this->_escape($tx);
            }
            $tj .= ')';
            $s .= sprintf(' BT ' . $aix . ' [%s] TJ ET ', $x * _MPDFK, ($this->h - $y) * _MPDFK, $tj);
        } else {    // CORE Font
            $s = '';
            $tj = '(';
            $l = strlen($txt);
            for ($i = 0; $i < $l; $i++) {
                if ($i > 0 && isset($this->CurrentFont['kerninfo'][$txt[($i - 1)]][$txt[$i]])) {
                    $kern = -$this->CurrentFont['kerninfo'][$txt[($i - 1)]][$txt[$i]];
                    $tj .= sprintf(')%d(', $kern);
                }
                $tj .= $this->_escape($txt[$i]);
            }
            $tj .= ')';
            $s .= sprintf(' BT ' . $aix . ' [%s] TJ ET ', $x * _MPDFK, ($this->h - $y) * _MPDFK, $tj);
        }

        return $s;
    }

    /*-- END HTML-CSS --*/

    function UTF8ToUTF16BE($str, $setbom = true)
    {
        if ($this->checkSIP && preg_match("/([\x{20000}-\x{2FFFF}])/u", $str)) {
            if (!in_array($this->currentfontfamily, array('gb', 'big5', 'sjis', 'uhc', 'gbB', 'big5B', 'sjisB', 'uhcB', 'gbI', 'big5I', 'sjisI', 'uhcI',
                'gbBI', 'big5BI', 'sjisBI', 'uhcBI'))) {
                $str = preg_replace("/[\x{20000}-\x{2FFFF}]/u", chr(0), $str);
            }
        }
        if ($this->checkSMP && preg_match("/([\x{10000}-\x{1FFFF}])/u", $str)) {
            $str = preg_replace("/[\x{10000}-\x{1FFFF}]/u", chr(0), $str);
        }
        $outstr = ""; // string to be returned
        if ($setbom) {
            $outstr .= "\xFE\xFF"; // Byte Order Mark (BOM)
        }
        $outstr .= mb_convert_encoding($str, 'UTF-16BE', 'UTF-8');
        return $outstr;
    }

    function _escape($s)
    {
        // the chr(13) substitution fixes the Bugs item #1421290.
        return strtr($s, array(')' => '\\)', '(' => '\\(', '\\' => '\\\\', chr(13) => '\r'));
    }

    function _smallCaps($txt, $mode, $aix, $dx, $k, $baseline, $va)
    {
        $upp = false;
        $str = array();
        $bits = array();
        if (!$this->usingCoreFont) {
            $unicode = $this->UTF8StringToArray($txt);
            foreach ($unicode as $char) {
                if ($this->ws && $char == 32) {    // space
                    if (count($str)) {
                        $bits[] = array($upp, $str, false);
                    }
                    $bits[] = array(false, array(32), true);
                    $str = array();
                    $upp = false;
                } else if (isset($this->upperCase[$char])) {
                    if (!$upp) {
                        if (count($str)) {
                            $bits[] = array($upp, $str, false);
                        }
                        $str = array();
                    }
                    $str[] = $this->upperCase[$char];
                    if ((!isset($this->CurrentFont['sip']) || !$this->CurrentFont['sip']) && (!isset($this->CurrentFont['smp']) || !$this->CurrentFont['smp'])) {
                        $this->CurrentFont['subset'][$this->upperCase[$char]] = $this->upperCase[$char];
                    }
                    $upp = true;
                } else {
                    if ($upp) {
                        if (count($str)) {
                            $bits[] = array($upp, $str, false);
                        }
                        $str = array();
                    }
                    $str[] = $char;
                    $upp = false;
                }
            }
        } else {
            for ($i = 0; $i < strlen($txt); $i++) {
                if (isset($this->upperCase[ord($txt[$i])]) && $this->upperCase[ord($txt[$i])] < 256) {
                    if (!$upp) {
                        if (count($str)) {
                            $bits[] = array($upp, $str, false);
                        }
                        $str = array();
                    }
                    $str[] = $this->upperCase[ord($txt[$i])];
                    $upp = true;
                } else {
                    if ($upp) {
                        if (count($str)) {
                            $bits[] = array($upp, $str, false);
                        }
                        $str = array();
                    }
                    $str[] = ord($txt[$i]);
                    $upp = false;
                }
            }
        }
        if (count($str)) {
            $bits[] = array($upp, $str, false);
        }

        $fid = $this->CurrentFont['i'];

        $s = sprintf(' BT ' . $aix, ($this->x + $dx) * $k, ($this->h - ($this->y + $baseline + $va)) * $k);
        foreach ($bits AS $b) {
            if ($b[0]) {
                $upp = true;
            } else {
                $upp = false;
            }

            $size = count($b[1]);
            $txt = '';
            for ($i = 0; $i < $size; $i++) {
                $txt .= code2utf($b[1][$i]);
            }
            if ($this->usingCoreFont) {
                $txt = utf8_decode($txt);
            }
            if ($mode == 'SIPSMP') {
                $txt = $this->UTF8toSubset($txt);
            } else {
                if (!$this->usingCoreFont) {
                    $txt = $this->UTF8ToUTF16BE($txt, false);
                }
                $txt = $this->_escape($txt);
                $txt = '(' . $txt . ')';
            }
            if ($b[2]) { // space
                $s .= sprintf(' /F%d %.3F Tf %d Tz', $fid, $this->FontSizePt, 100);
                $s .= sprintf(' %.3F Tc', ($this->charspacing + $this->ws));
                $s .= sprintf(' %s Tj', $txt);
            } else if ($upp) {
                $s .= sprintf(' /F%d %.3F Tf', $fid, $this->FontSizePt * $this->smCapsScale);
                $s .= sprintf(' %d Tz', $this->smCapsStretch);
                $s .= sprintf(' %.3F Tc', ($this->charspacing * 100 / $this->smCapsStretch));
                $s .= sprintf(' %s Tj', $txt);
            } else {
                $s .= sprintf(' /F%d %.3F Tf %d Tz', $fid, $this->FontSizePt, 100);
                $s .= sprintf(' %.3F Tc', ($this->charspacing));
                $s .= sprintf(' %s Tj', $txt);
            }
        }
        $s .= ' ET ';
        return $s;
    }

    function UTF8toSubset($str)
    {
        $ret = '<';
        $str = preg_replace('/' . preg_quote($this->aliasNbPg, '/') . '/', chr(7), $str);
        $str = preg_replace('/' . preg_quote($this->aliasNbPgGp, '/') . '/', chr(8), $str);
        $unicode = $this->UTF8StringToArray($str);
        $orig_fid = $this->CurrentFont['subsetfontids'][0];
        $last_fid = $this->CurrentFont['subsetfontids'][0];
        foreach ($unicode as $c) {
            if ($c == 7 || $c == 8) {
                if ($orig_fid != $last_fid) {
                    $ret .= '> Tj /F' . $orig_fid . ' ' . $this->FontSizePt . ' Tf <';
                    $last_fid = $orig_fid;
                }
                if ($c == 7) {
                    $ret .= $this->aliasNbPgHex;
                } else {
                    $ret .= $this->aliasNbPgGpHex;
                }
                continue;
            }
            for ($i = 0; $i < 99; $i++) {
                // return c as decimal char
                $init = array_search($c, $this->CurrentFont['subsets'][$i]);
                if ($init !== false) {
                    if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
                        $ret .= '> Tj /F' . $this->CurrentFont['subsetfontids'][$i] . ' ' . $this->FontSizePt . ' Tf <';
                        $last_fid = $this->CurrentFont['subsetfontids'][$i];
                    }
                    $ret .= sprintf("%02s", strtoupper(dechex($init)));
                    break;
                } // TrueType embedded SUBSETS
                else if (count($this->CurrentFont['subsets'][$i]) < 255) {
                    $n = count($this->CurrentFont['subsets'][$i]);
                    $this->CurrentFont['subsets'][$i][$n] = $c;
                    if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
                        $ret .= '> Tj /F' . $this->CurrentFont['subsetfontids'][$i] . ' ' . $this->FontSizePt . ' Tf <';
                        $last_fid = $this->CurrentFont['subsetfontids'][$i];
                    }
                    $ret .= sprintf("%02s", strtoupper(dechex($n)));
                    break;
                } else if (!isset($this->CurrentFont['subsets'][($i + 1)])) {
                    // TrueType embedded SUBSETS
                    $this->CurrentFont['subsets'][($i + 1)] = array(0 => 0);
                    $new_fid = count($this->fonts) + $this->extraFontSubsets + 1;
                    $this->CurrentFont['subsetfontids'][($i + 1)] = $new_fid;
                    $this->extraFontSubsets++;
                }
            }
        }
        $ret .= '>';
        if ($last_fid != $orig_fid) {
            $ret .= ' Tj /F' . $orig_fid . ' ' . $this->FontSizePt . ' Tf <> ';
        }
        return $ret;
    }


// *****************************************************************************
//                                                                             *
//                             Protected methods                               *
//                                                                             *
// *****************************************************************************

    function _dounderline($x, $y, $txt)
    {
        // Now print line exactly where $y secifies - called from Text() and Cell() - adjust  position there
        // WORD SPACING
        $w = ($this->GetStringWidth($txt) * _MPDFK) + ($this->charspacing * mb_strlen($txt, $this->mb_enc))
            + ($this->ws * mb_substr_count($txt, ' ', $this->mb_enc));
        //Draw a line
        return sprintf('%.3F %.3F m %.3F %.3F l S', $x * _MPDFK, ($this->h - $y) * _MPDFK, ($x * _MPDFK) + $w, ($this->h - $y) * _MPDFK);
    }

    function Link($x, $y, $w, $h, $link)
    {
        $l = array($x * _MPDFK, $this->hPt - $y * _MPDFK, $w * _MPDFK, $h * _MPDFK, $link);
        if ($this->keep_block_together) {    // Save to array - don't write yet
            $this->ktLinks[$this->page][] = $l;
            return;
        } else if ($this->table_rotate) {    // *TABLES*
            $this->tbrot_Links[$this->page][] = $l;    // *TABLES*
            return;    // *TABLES*
        }    // *TABLES*
        else if ($this->kwt) {
            $this->kwt_Links[$this->page][] = $l;
            return;
        }

        if ($this->writingHTMLheader || $this->writingHTMLfooter) {
            $this->HTMLheaderPageLinks[] = $l;
            return;
        }
        //Put a link on the page
        $this->PageLinks[$this->page][] = $l;
        // Save cross-reference to Column buffer
        $ref = count($this->PageLinks[$this->page]) - 1;    // *COLUMNS*
        $this->columnLinks[$this->CurrCol][INTVAL($this->x)][INTVAL($this->y)] = $ref;    // *COLUMNS*

    }


    /*-- HTMLHEADERS-FOOTERS --*/

    function _setBorderLine($b, $k = 1)
    {
        $this->SetLineWidth($b['w'] / $k);
        $this->SetDColor($b['c']);
        if ($b['c'][0] == 5) {    // RGBa
            $this->SetAlpha(ord($b['c'][4]) / 100, 'Normal', false, 'S') . "\n";    // mPDF 5.7.2
        } else if ($b['c'][0] == 6) {    // CMYKa
            $this->SetAlpha(ord($b['c'][5]) / 100, 'Normal', false, 'S') . "\n";    // mPDF 5.7.2
        }
    }

    /*-- END HTMLHEADERS-FOOTERS --*/

    function _setDashBorder($style, $div, $cp, $side)
    {
        if ($style == 'dashed' && (($side == 'L' || $side == 'R') || ($side == 'T' && $div != 'pagetop' && !$cp) || ($side == 'B' && $div != 'pagebottom'))) {
            $dashsize = 2;    // final dash will be this + 1*linewidth
            $dashsizek = 1.5;    // ratio of Dash/Blank
            $this->SetDash($dashsize, ($dashsize / $dashsizek) + ($this->LineWidth * 2));
        } else if ($style == 'dotted' || ($side == 'T' && ($div == 'pagetop' || $cp)) || ($side == 'B' && $div == 'pagebottom')) {
            //Round join and cap
            $this->SetLineJoin(1);
            $this->SetLineCap(1);
            $this->SetDash(0.001, ($this->LineWidth * 3));
        }
    }

    function _EllipseArc($x0, $y0, $rx, $ry, $seg = 1, $part = false, $start = false)
    {    // Anticlockwise segment 1-4 TR-TL-BL-BR (part=1 or 2)
        $s = '';
        if ($rx < 0) {
            $rx = 0;
        }
        if ($ry < 0) {
            $ry = 0;
        }
        $rx *= _MPDFK;
        $ry *= _MPDFK;
        $astart = 0;
        if ($seg == 1) {    // Top Right
            $afinish = 90;
            $nSeg = 4;
        } else if ($seg == 2) {    // Top Left
            $afinish = 180;
            $nSeg = 8;
        } else if ($seg == 3) {    // Bottom Left
            $afinish = 270;
            $nSeg = 12;
        } else {            // Bottom Right
            $afinish = 360;
            $nSeg = 16;
        }
        $astart = deg2rad((float)$astart);
        $afinish = deg2rad((float)$afinish);
        $totalAngle = $afinish - $astart;
        $dt = $totalAngle / $nSeg;    // segment angle
        $dtm = $dt / 3;
        $x0 *= _MPDFK;
        $y0 = ($this->h - $y0) * _MPDFK;
        $t1 = $astart;
        $a0 = $x0 + ($rx * cos($t1));
        $b0 = $y0 + ($ry * sin($t1));
        $c0 = -$rx * sin($t1);
        $d0 = $ry * cos($t1);
        $op = false;
        for ($i = 1; $i <= $nSeg; $i++) {
            // Draw this bit of the total curve
            $t1 = ($i * $dt) + $astart;
            $a1 = $x0 + ($rx * cos($t1));
            $b1 = $y0 + ($ry * sin($t1));
            $c1 = -$rx * sin($t1);
            $d1 = $ry * cos($t1);
            if ($i > ($nSeg - 4) && (!$part || ($part == 1 && $i <= $nSeg - 2) || ($part == 2 && $i > $nSeg - 2))) {
                if ($start && !$op) {
                    $s .= sprintf('%.3F %.3F m ', $a0, $b0);
                }
                $s .= sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', ($a0 + ($c0 * $dtm)), ($b0 + ($d0 * $dtm)), ($a1 - ($c1 * $dtm)), ($b1 - ($d1 * $dtm)), $a1, $b1);
                $op = true;
            }
            $a0 = $a1;
            $b0 = $b1;
            $c0 = $c1;
            $d0 = $d1;
        }
        return $s;
    }


    /*-- ANNOTATIONS --*/

    function PrintPageBackgrounds($adjustmenty = 0)
    {
        $s = '';

        ksort($this->pageBackgrounds);
        foreach ($this->pageBackgrounds AS $bl => $pbs) {
            foreach ($pbs AS $pb) {
                if ((!isset($pb['image_id']) && !isset($pb['gradient'])) || isset($pb['shadowonly'])) {    // Background colour or boxshadow
                    // mPDF 5.6.01  - LAYERS
                    if ($pb['z-index'] > 0) {
                        $this->current_layer = $pb['z-index'];
                        $s .= "\n" . '/OCBZ-index /ZI' . $pb['z-index'] . ' BDC' . "\n";
                    }

                    if ($pb['visibility'] != 'visible') {
                        if ($pb['visibility'] == 'printonly')
                            $s .= '/OC /OC1 BDC' . "\n";
                        else if ($pb['visibility'] == 'screenonly')
                            $s .= '/OC /OC2 BDC' . "\n";
                        else if ($pb['visibility'] == 'hidden')
                            $s .= '/OC /OC3 BDC' . "\n";
                    }
                    // Box shadow
                    if (isset($pb['shadow']) && $pb['shadow']) {
                        $s .= $pb['shadow'] . "\n";
                    }
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= $pb['clippath'] . "\n";
                    }
                    $s .= 'q ' . $this->SetFColor($pb['col'], true) . "\n";
                    if ($pb['col']{0} == 5) {    // RGBa
                        $s .= $this->SetAlpha(ord($pb['col']{4}) / 100, 'Normal', true, 'F') . "\n";
                    } else if ($pb['col']{0} == 6) {    // CMYKa
                        $s .= $this->SetAlpha(ord($pb['col']{5}) / 100, 'Normal', true, 'F') . "\n";
                    }
                    $s .= sprintf('%.3F %.3F %.3F %.3F re f Q', $pb['x'] * _MPDFK, ($this->h - $pb['y']) * _MPDFK, $pb['w'] * _MPDFK, -$pb['h'] * _MPDFK) . "\n";
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= 'Q' . "\n";
                    }
                    if ($pb['visibility'] != 'visible')
                        $s .= 'EMC' . "\n";

                    // mPDF 5.6.01  - LAYERS
                    if ($pb['z-index'] > 0) {
                        $s .= "\n" . 'EMCBZ-index' . "\n";
                        $this->current_layer = 0;
                    }
                }
            }
            /*-- BACKGROUNDS --*/
            foreach ($pbs AS $pb) {
                // mPDF 5.6.01  - LAYERS
                if ((isset($pb['gradient']) && $pb['gradient']) || (isset($pb['image_id']) && $pb['image_id'])) {
                    if ($pb['z-index'] > 0) {
                        $this->current_layer = $pb['z-index'];
                        $s .= "\n" . '/OCGZ-index /ZI' . $pb['z-index'] . ' BDC' . "\n";
                    }
                    if ($pb['visibility'] != 'visible') {
                        if ($pb['visibility'] == 'printonly')
                            $s .= '/OC /OC1 BDC' . "\n";
                        else if ($pb['visibility'] == 'screenonly')
                            $s .= '/OC /OC2 BDC' . "\n";
                        else if ($pb['visibility'] == 'hidden')
                            $s .= '/OC /OC3 BDC' . "\n";
                    }
                }
                if (isset($pb['gradient']) && $pb['gradient']) {
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= $pb['clippath'] . "\n";
                    }
                    $s .= $this->grad->Gradient($pb['x'], $pb['y'], $pb['w'], $pb['h'], $pb['gradtype'], $pb['stops'], $pb['colorspace'], $pb['coords'], $pb['extend'], true);
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= 'Q' . "\n";
                    }
                } else if (isset($pb['image_id']) && $pb['image_id']) {    // Background Image
                    $pb['y'] -= $adjustmenty;
                    $pb['h'] += $adjustmenty;
                    $n = count($this->patterns) + 1;
                    list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($pb['orig_w'], $pb['orig_h'], $pb['w'], $pb['h'], $pb['resize'], $pb['x_repeat'], $pb['y_repeat'], $pb['bpa'], $pb['size']);    // mPDF 5.6.10
                    $this->patterns[$n] = array('x' => $pb['x'], 'y' => $pb['y'], 'w' => $pb['w'], 'h' => $pb['h'], 'pgh' => $this->h, 'image_id' => $pb['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $pb['x_pos'], 'y_pos' => $pb['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $pb['itype'], 'bpa' => $pb['bpa']);    // mPDF 5.6.10
                    $x = $pb['x'] * _MPDFK;
                    $y = ($this->h - $pb['y']) * _MPDFK;
                    $w = $pb['w'] * _MPDFK;
                    $h = -$pb['h'] * _MPDFK;
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= $pb['clippath'] . "\n";
                    }
                    if ($this->writingHTMLfooter || $this->writingHTMLheader) {    // Write each (tiles) image rather than use as a pattern
                        $iw = $pb['orig_w'] / _MPDFK;
                        $ih = $pb['orig_h'] / _MPDFK;

                        $w = $pb['w'];
                        $h = $pb['h'];
                        $x0 = $pb['x'];
                        $y0 = $pb['y'];

                        // mPDF 5.6.11
                        if (isset($pb['bpa']) && $pb['bpa']) {
                            $w = $pb['bpa']['w'];
                            $h = $pb['bpa']['h'];
                            $x0 = $pb['bpa']['x'];
                            $y0 = $pb['bpa']['y'];
                        }

                        // mPDF 5.6.11
                        if (isset($pb['size']['w']) && $pb['size']['w']) {
                            $size = $pb['size'];

                            if ($size['w'] == 'contain') {
                                // Scale the image, while preserving its intrinsic aspect ratio (if any), to the largest size such that both its width and its height can fit inside the background positioning area.
                                // Same as resize==3
                                $ih = $ih * $pb['bpa']['w'] / $iw;
                                $iw = $pb['bpa']['w'];
                                if ($ih > $pb['bpa']['h']) {
                                    $iw = $iw * $pb['bpa']['h'] / $ih;
                                    $ih = $pb['bpa']['h'];
                                }
                            } else if ($size['w'] == 'cover') {
                                // Scale the image, while preserving its intrinsic aspect ratio (if any), to the smallest size such that both its width and its height can completely cover the background positioning area.
                                $ih = $ih * $pb['bpa']['w'] / $iw;
                                $iw = $pb['bpa']['w'];
                                if ($ih < $pb['bpa']['h']) {
                                    $iw = $iw * $ih / $pb['bpa']['h'];
                                    $ih = $pb['bpa']['h'];
                                }
                            } else {
                                if (stristr($size['w'], '%')) {
                                    $size['w'] += 0;
                                    $size['w'] /= 100;
                                    $size['w'] = ($pb['bpa']['w'] * $size['w']);
                                }
                                if (stristr($size['h'], '%')) {
                                    $size['h'] += 0;
                                    $size['h'] /= 100;
                                    $size['h'] = ($pb['bpa']['h'] * $size['h']);
                                }
                                if ($size['w'] == 'auto' && $size['h'] == 'auto') {
                                    $iw = $iw;
                                    $ih = $ih;
                                } else if ($size['w'] == 'auto' && $size['h'] != 'auto') {
                                    $iw = $iw * $size['h'] / $ih;
                                    $ih = $size['h'];
                                } else if ($size['w'] != 'auto' && $size['h'] == 'auto') {
                                    $ih = $ih * $size['w'] / $iw;
                                    $iw = $size['w'];
                                } else {
                                    $iw = $size['w'];
                                    $ih = $size['h'];
                                }
                            }
                        }

                        // Number to repeat
                        if ($pb['x_repeat']) {
                            $nx = ceil($pb['w'] / $iw) + 1;
                        }    // mPDF 5.6.11
                        else {
                            $nx = 1;
                        }
                        if ($pb['y_repeat']) {
                            $ny = ceil($pb['h'] / $ih) + 1;
                        }    // mPDF 5.6.11
                        else {
                            $ny = 1;
                        }

                        $x_pos = $pb['x_pos'];
                        if (stristr($x_pos, '%')) {
                            $x_pos += 0;
                            $x_pos /= 100;
                            $x_pos = ($pb['bpa']['w'] * $x_pos) - ($iw * $x_pos);    // mPDF 5.6.11
                        }
                        $y_pos = $pb['y_pos'];
                        if (stristr($y_pos, '%')) {
                            $y_pos += 0;
                            $y_pos /= 100;
                            $y_pos = ($pb['bpa']['h'] * $y_pos) - ($ih * $y_pos);    // mPDF 5.6.11
                        }
                        if ($nx > 1) {
                            while ($x_pos > ($pb['x'] - $pb['bpa']['x'])) {
                                $x_pos -= $iw;
                            }    // mPDF 5.6.11
                        }
                        if ($ny > 1) {
                            while ($y_pos > ($pb['y'] - $pb['bpa']['y'])) {
                                $y_pos -= $ih;
                            }    // mPDF 5.6.11
                        }
                        for ($xi = 0; $xi < $nx; $xi++) {
                            for ($yi = 0; $yi < $ny; $yi++) {
                                $x = $x0 + $x_pos + ($iw * $xi);
                                $y = $y0 + $y_pos + ($ih * $yi);
                                if ($pb['opacity'] > 0 && $pb['opacity'] < 1) {
                                    $opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
                                } else {
                                    $opac = '';
                                }
                                $s .= sprintf("q %s %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $opac, $iw * _MPDFK, $ih * _MPDFK, $x * _MPDFK, ($this->h - ($y + $ih)) * _MPDFK, $pb['image_id']) . "\n";
                            }
                        }
                    } else {
                        if (($pb['opacity'] > 0 || $pb['opacity'] === '0') && $pb['opacity'] < 1) {
                            $opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
                        } else {
                            $opac = '';
                        }
                        $s .= sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, $x, $y, $w, $h) . "\n";
                    }
                    if (isset($pb['clippath']) && $pb['clippath']) {
                        $s .= 'Q' . "\n";
                    }
                }
                if ((isset($pb['gradient']) && $pb['gradient']) || (isset($pb['image_id']) && $pb['image_id'])) {
                    if ($pb['visibility'] != 'visible')
                        $s .= 'EMC' . "\n";

                    // mPDF 5.6.01  - LAYERS
                    if ($pb['z-index'] > 0) {
                        $s .= "\n" . 'EMCGZ-index' . "\n";
                        $this->current_layer = 0;
                    }
                }

            }
            /*-- END BACKGROUNDS --*/
        }
        return $s;
    }

    /*-- END ANNOTATIONS --*/

    function _resizeBackgroundImage($imw, $imh, $cw, $ch, $resize = 0, $repx, $repy, $pba = array(), $size = array())
    {    // mPDF 5.6.10
        // pba is background positioning area (from CSS background-origin) may not always be set [x,y,w,h]
        // size is from CSS3 background-size - takes precendence over old resize
        //	$w - absolute length or % or auto or cover | contain
        //	$h - absolute length or % or auto or cover | contain
        // mPDF 5.6.10
        if (isset($pba['w'])) $cw = $pba['w'];
        if (isset($pba['h'])) $ch = $pba['h'];

        $cw = $cw * _MPDFK;
        $ch = $ch * _MPDFK;
        if (empty($size) && !$resize) {
            return array($imw, $imh, $repx, $repy);
        }

        // mPDF 5.6.10
        if (isset($size['w']) && $size['w']) {
            if ($size['w'] == 'contain') {
                // Scale the image, while preserving its intrinsic aspect ratio (if any), to the largest size such that both its width and its height can fit inside the background positioning area.
                // Same as resize==3
                $h = $imh * $cw / $imw;
                $w = $cw;
                if ($h > $ch) {
                    $w = $w * $ch / $h;
                    $h = $ch;
                }
            } else if ($size['w'] == 'cover') {
                // Scale the image, while preserving its intrinsic aspect ratio (if any), to the smallest size such that both its width and its height can completely cover the background positioning area.
                $h = $imh * $cw / $imw;
                $w = $cw;
                if ($h < $ch) {
                    $w = $w * $h / $ch;
                    $h = $ch;
                }
            } else {
                if (stristr($size['w'], '%')) {
                    $size['w'] += 0;
                    $size['w'] /= 100;
                    $size['w'] = ($cw * $size['w']);
                }
                if (stristr($size['h'], '%')) {
                    $size['h'] += 0;
                    $size['h'] /= 100;
                    $size['h'] = ($ch * $size['h']);
                }
                if ($size['w'] == 'auto' && $size['h'] == 'auto') {
                    $w = $imw;
                    $h = $imh;
                } else if ($size['w'] == 'auto' && $size['h'] != 'auto') {
                    $w = $imw * $size['h'] / $imh;
                    $h = $size['h'];
                } else if ($size['w'] != 'auto' && $size['h'] == 'auto') {
                    $h = $imh * $size['w'] / $imw;
                    $w = $size['w'];
                } else {
                    $w = $size['w'];
                    $h = $size['h'];
                }
            }
            return array($w, $h, $repx, $repy);
        } else if ($resize == 1 && $imw > $cw) {
            $h = $imh * $cw / $imw;
            return array($cw, $h, $repx, $repy);
        } else if ($resize == 2 && $imh > $ch) {
            $w = $imw * $ch / $imh;
            return array($w, $ch, $repx, $repy);
        } else if ($resize == 3) {
            $w = $imw;
            $h = $imh;
            if ($w > $cw) {
                $h = $h * $cw / $w;
                $w = $cw;
            }
            if ($h > $ch) {
                $w = $w * $ch / $h;
                $h = $ch;
            }
            return array($w, $h, $repx, $repy);
        } else if ($resize == 4) {
            $h = $imh * $cw / $imw;
            return array($cw, $h, $repx, $repy);
        } else if ($resize == 5) {
            $w = $imw * $ch / $imh;
            return array($w, $ch, $repx, $repy);
        } else if ($resize == 6) {
            return array($cw, $ch, $repx, $repy);
        }
        return array($imw, $imh, $repx, $repy);
    }

    function printfloatbuffer()
    {
        if (count($this->floatbuffer)) {
            $this->objectbuffer = $this->floatbuffer;
            $this->printobjectbuffer(false);
            $this->objectbuffer = array();
            $this->floatbuffer = array();
            $this->floatmargins = array();
        }
    }

    function printobjectbuffer($is_table = false, $blockdir = false)
    {
        if (!$blockdir) {
            $blockdir = $this->directionality;
        }
        if ($is_table && $this->shrin_k > 1) {
            $k = $this->shrin_k;
        } else {
            $k = 1;
        }
        $save_y = $this->y;
        $save_x = $this->x;
        $save_currentfontfamily = $this->FontFamily;
        $save_currentfontsize = $this->FontSizePt;
        $save_currentfontstyle = $this->FontStyle . ($this->U ? 'U' : '') . ($this->S ? 'S' : '');
        if ($blockdir == 'rtl') {
            $rtlalign = 'R';
        } else {
            $rtlalign = 'L';
        }
        foreach ($this->objectbuffer AS $ib => $objattr) {
            if ($objattr['type'] == 'bookmark' || $objattr['type'] == 'indexentry' || $objattr['type'] == 'toc') {
                $x = $objattr['OUTER-X'];
                $y = $objattr['OUTER-Y'];
                $this->y = $y - $this->FontSize / 2;
                $this->x = $x;
                if ($objattr['type'] == 'bookmark') {
                    $this->Bookmark($objattr['CONTENT'], $objattr['bklevel'], $y - $this->FontSize);
                }    // *BOOKMARKS*
                if ($objattr['type'] == 'indexentry') {
                    $this->IndexEntry($objattr['CONTENT']);
                }    // *INDEX*
                if ($objattr['type'] == 'toc') {
                    $this->TOC_Entry($objattr['CONTENT'], $objattr['toclevel'], $objattr['toc_id']);
                }    // *TOC*
            } /*-- ANNOTATIONS --*/
            else if ($objattr['type'] == 'annot') {
                if ($objattr['POS-X']) {
                    $x = $objattr['POS-X'];
                } else if ($this->annotMargin <> 0) {
                    $x = -$objattr['OUTER-X'];
                } else {
                    $x = $objattr['OUTER-X'];
                }
                if ($objattr['POS-Y']) {
                    $y = $objattr['POS-Y'];
                } else {
                    $y = $objattr['OUTER-Y'] - $this->FontSize / 2;
                }
                // Create a dummy entry in the _out/columnBuffer with position sensitive data,
                // linking $y-1 in the Columnbuffer with entry in $this->columnAnnots
                // and when columns are split in length will not break annotation from current line
                $this->y = $y - 1;
                $this->x = $x - 1;
                $this->Line($x - 1, $y - 1, $x - 1, $y - 1);
                $this->Annotation($objattr['CONTENT'], $x, $y, $objattr['ICON'], $objattr['AUTHOR'], $objattr['SUBJECT'], $objattr['OPACITY'], $objattr['COLOR'], $objattr['POPUP'], $objattr['FILE']);
            } /*-- END ANNOTATIONS --*/
            else {
                $y = $objattr['OUTER-Y'];
                $x = $objattr['OUTER-X'];
                $w = $objattr['OUTER-WIDTH'];
                $h = $objattr['OUTER-HEIGHT'];
                if (isset($objattr['text'])) {
                    $texto = $objattr['text'];
                }
                $this->y = $y;
                $this->x = $x;
                if (isset($objattr['fontfamily'])) {
                    $this->SetFont($objattr['fontfamily'], '', $objattr['fontsize']);
                }
            }

            // HR
            if ($objattr['type'] == 'hr') {
                $this->SetDColor($objattr['color']);
                switch ($objattr['align']) {
                    case 'C':
                        $empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
                        $empty /= 2;
                        $x += $empty;
                        break;
                    case 'R':
                        $empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
                        $x += $empty;
                        break;
                }
                $oldlinewidth = $this->LineWidth;
                $this->SetLineWidth($objattr['linewidth'] / $k);
                $this->y += ($objattr['linewidth'] / 2) + $objattr['margin_top'] / $k;
                $this->Line($x, $this->y, $x + $objattr['INNER-WIDTH'], $this->y);
                $this->SetLineWidth($oldlinewidth);
                $this->SetDColor($this->ConvertColor(0));
            }
            // IMAGE
            if ($objattr['type'] == 'image') {
                // mPDF 5.7.3 TRANSFORMS
                if (isset($objattr['transform'])) {
                    $this->_out("\n" . '% BTR');    // Begin Transform
                }
                if (isset($objattr['z-index']) && $objattr['z-index'] > 0 && $this->currentlayer == 0) {
                    $this->BeginLayer($objattr['z-index']);
                }
                if (isset($objattr['visibility']) && $objattr['visibility'] != 'visible' && $objattr['visibility']) {
                    $this->SetVisibility($objattr['visibility']);
                }
                if (isset($objattr['opacity'])) {
                    $this->SetAlpha($objattr['opacity']);
                }
                $rotate = 0;
                $obiw = $objattr['INNER-WIDTH'];
                $obih = $objattr['INNER-HEIGHT'];
                $sx = $objattr['INNER-WIDTH'] * _MPDFK / $objattr['orig_w'];
                $sy = abs($objattr['INNER-HEIGHT']) * _MPDFK / abs($objattr['orig_h']);
                $sx = ($objattr['INNER-WIDTH'] * _MPDFK / $objattr['orig_w']);
                $sy = ($objattr['INNER-HEIGHT'] * _MPDFK / $objattr['orig_h']);

                if (isset($objattr['ROTATE'])) {
                    $rotate = $objattr['ROTATE'];
                }
                if ($rotate == 90) {
                    // Clockwise
                    $obiw = $objattr['INNER-HEIGHT'];
                    $obih = $objattr['INNER-WIDTH'];
                    $tr = $this->transformTranslate(0, -$objattr['INNER-WIDTH'], true);
                    $tr .= ' ' . $this->transformRotate(90, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-WIDTH']), true);
                    $sx = $obiw * _MPDFK / $objattr['orig_h'];
                    $sy = $obih * _MPDFK / $objattr['orig_w'];
                } else if ($rotate == -90 || $rotate == 270) {
                    // AntiClockwise
                    $obiw = $objattr['INNER-HEIGHT'];
                    $obih = $objattr['INNER-WIDTH'];
                    $tr = $this->transformTranslate($objattr['INNER-WIDTH'], ($objattr['INNER-HEIGHT'] - $objattr['INNER-WIDTH']), true);
                    $tr .= ' ' . $this->transformRotate(-90, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-WIDTH']), true);
                    $sx = $obiw * _MPDFK / $objattr['orig_h'];
                    $sy = $obih * _MPDFK / $objattr['orig_w'];
                } else if ($rotate == 180) {
                    // Mirror
                    $tr = $this->transformTranslate($objattr['INNER-WIDTH'], -$objattr['INNER-HEIGHT'], true);
                    $tr .= ' ' . $this->transformRotate(180, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-HEIGHT']), true);
                } else {
                    $tr = '';
                }
                $tr = trim($tr);
                if ($tr) {
                    $tr .= ' ';
                }
                $gradmask = '';

                // mPDF 5.7.3 TRANSFORMS
                $tr2 = '';
                if (isset($objattr['transform'])) {
                    $maxsize_x = $w;
                    $maxsize_y = $h;
                    $cx = $x + $w / 2;
                    $cy = $y + $h / 2;
                    preg_match_all('/(translatex|translatey|translate|scalex|scaley|scale|rotate|skewX|skewY|skew)\((.*?)\)/is', $objattr['transform'], $m);
                    if (count($m[0])) {
                        for ($i = 0; $i < count($m[0]); $i++) {
                            $c = strtolower($m[1][$i]);
                            $v = trim($m[2][$i]);
                            $vv = preg_split('/[ ,]+/', $v);
                            if ($c == 'translate' && count($vv)) {
                                $translate_x = $this->ConvertSize($vv[0], $maxsize_x, false, false);
                                if (count($vv) == 2) {
                                    $translate_y = $this->ConvertSize($vv[1], $maxsize_y, false, false);
                                } else {
                                    $translate_y = 0;
                                }
                                $tr2 .= $this->transformTranslate($translate_x, $translate_y, true) . ' ';
                            } else if ($c == 'translatex' && count($vv)) {
                                $translate_x = $this->ConvertSize($vv[0], $maxsize_x, false, false);
                                $tr2 .= $this->transformTranslate($translate_x, 0, true) . ' ';
                            } else if ($c == 'translatey' && count($vv)) {
                                $translate_y = $this->ConvertSize($vv[1], $maxsize_y, false, false);
                                $tr2 .= $this->transformTranslate(0, $translate_y, true) . ' ';
                            } else if ($c == 'scale' && count($vv)) {
                                $scale_x = $vv[0] * 100;
                                if (count($vv) == 2) {
                                    $scale_y = $vv[1] * 100;
                                } else {
                                    $scale_y = $scale_x;
                                }
                                $tr2 .= $this->transformScale($scale_x, $scale_y, $cx, $cy, true) . ' ';
                            } else if ($c == 'scalex' && count($vv)) {
                                $scale_x = $vv[0] * 100;
                                $tr2 .= $this->transformScale($scale_x, 0, $cx, $cy, true) . ' ';
                            } else if ($c == 'scaley' && count($vv)) {
                                $scale_y = $vv[1] * 100;
                                $tr2 .= $this->transformScale(0, $scale_y, $cx, $cy, true) . ' ';
                            } else if ($c == 'skew' && count($vv)) {
                                $angle_x = $this->ConvertAngle($vv[0], false);
                                if (count($vv) == 2) {
                                    $angle_y = $this->ConvertAngle($vv[1], false);
                                } else {
                                    $angle_y = 0;
                                }
                                $tr2 .= $this->transformSkew($angle_x, $angle_y, $cx, $cy, true) . ' ';
                            } else if ($c == 'skewx' && count($vv)) {
                                $angle = $this->ConvertAngle($vv[0], false);
                                $tr2 .= $this->transformSkew($angle, 0, $cx, $cy, true) . ' ';
                            } else if ($c == 'skewy' && count($vv)) {
                                $angle = $this->ConvertAngle($vv[0], false);
                                $tr2 .= $this->transformSkew(0, $angle, $cx, $cy, true) . ' ';
                            } else if ($c == 'rotate' && count($vv)) {
                                $angle = $this->ConvertAngle($vv[0]);
                                $tr2 .= $this->transformRotate($angle, $cx, $cy, true) . ' ';
                            }
                        }
                    }
                }
                // mPDF 5.7.3 TRANSFORMS / BACKGROUND COLOR
                // Transform also affects image background
                if ($tr2) {
                    $this->_out('q ' . $tr2 . ' ');
                }
                if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
                    $bgcol = $objattr['bgcolor'];
                    $this->SetFColor($bgcol);
                    $this->Rect($x, $y, $w, $h, 'F');
                    $this->SetFColor($this->ConvertColor(255));
                }
                if ($tr2) {
                    $this->_out('Q');
                }

                /*-- BACKGROUNDS --*/
                if (isset($objattr['GRADIENT-MASK'])) {
                    $g = $this->grad->parseMozGradient($objattr['GRADIENT-MASK']);
                    if ($g) {
                        $dummy = $this->grad->Gradient($objattr['INNER-X'], $objattr['INNER-Y'], $obiw, $obih, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true, true);
                        $gradmask = '/TGS' . count($this->gradients) . ' gs ';
                        // $this->_out("q ".$tr.$this->grad->Gradient($objattr['INNER-X'], $objattr['INNER-Y'], $obiw, $obih, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true)." Q");
                    }
                }
                /*-- END BACKGROUNDS --*/
                /*-- IMAGES-WMF --*/
                if (isset($objattr['itype']) && $objattr['itype'] == 'wmf') {
                    $outstring = sprintf('q ' . $tr . $tr2 . '%.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, -$sy, $objattr['INNER-X'] * _MPDFK - $sx * $objattr['wmf_x'], (($this->h - $objattr['INNER-Y']) * _MPDFK) + $sy * $objattr['wmf_y'], $objattr['ID']);    // mPDF 5.7.3 TRANSFORMS
                } else
                    /*-- END IMAGES-WMF --*/
                    if (isset($objattr['itype']) && $objattr['itype'] == 'svg') {
                        $outstring = sprintf('q ' . $tr . $tr2 . '%.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, -$sy, $objattr['INNER-X'] * _MPDFK - $sx * $objattr['wmf_x'], (($this->h - $objattr['INNER-Y']) * _MPDFK) + $sy * $objattr['wmf_y'], $objattr['ID']);    // mPDF 5.7.3 TRANSFORMS
                    } else {
                        $outstring = sprintf("q " . $tr . $tr2 . "%.3F 0 0 %.3F %.3F %.3F cm " . $gradmask . "/I%d Do Q", $obiw * _MPDFK, $obih * _MPDFK, $objattr['INNER-X'] * _MPDFK, ($this->h - ($objattr['INNER-Y'] + $obih)) * _MPDFK, $objattr['ID']);    // mPDF 5.7.3 TRANSFORMS
                    }
                $this->_out($outstring);
                // LINK
                if (isset($objattr['link'])) $this->Link($objattr['INNER-X'], $objattr['INNER-Y'], $objattr['INNER-WIDTH'], $objattr['INNER-HEIGHT'], $objattr['link']);
                if (isset($objattr['opacity'])) {
                    $this->SetAlpha(1);
                }

                // mPDF 5.7.3 TRANSFORMS
                // Transform also affects image borders
                if ($tr2) {
                    $this->_out('q ' . $tr2 . ' ');
                }
                if ((isset($objattr['border_top']) && $objattr['border_top'] > 0) || (isset($objattr['border_left']) && $objattr['border_left'] > 0) || (isset($objattr['border_right']) && $objattr['border_right'] > 0) || (isset($objattr['border_bottom']) && $objattr['border_bottom'] > 0)) {
                    $this->PaintImgBorder($objattr, $is_table);
                }
                if ($tr2) {
                    $this->_out('Q');
                }

                if (isset($objattr['visibility']) && $objattr['visibility'] != 'visible' && $objattr['visibility']) {
                    $this->SetVisibility('visible');
                }
                if (isset($objattr['z-index']) && $objattr['z-index'] > 0 && $this->currentlayer == 0) {
                    $this->EndLayer();
                }
                // mPDF 5.7.3 TRANSFORMS
                if (isset($objattr['transform'])) {
                    $this->_out("\n" . '% ETR');    // Begin Transform
                }
            }

            /*-- BARCODES --*/
            // BARCODE
            if ($objattr['type'] == 'barcode') {
                $bgcol = $this->ConvertColor(255);
                if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
                    $bgcol = $objattr['bgcolor'];
                }
                $col = $this->ConvertColor(0);
                if (isset($objattr['color']) && $objattr['color']) {
                    $col = $objattr['color'];
                }
                $this->SetFColor($bgcol);
                $this->Rect($objattr['BORDER-X'], $objattr['BORDER-Y'], $objattr['BORDER-WIDTH'], $objattr['BORDER-HEIGHT'], 'F');
                $this->SetFColor($this->ConvertColor(255));
                if (isset($objattr['BORDER-WIDTH'])) {
                    $this->PaintImgBorder($objattr, $is_table);
                }
                if ($objattr['btype'] == 'EAN13' || $objattr['btype'] == 'ISBN' || $objattr['btype'] == 'ISSN' || $objattr['btype'] == 'UPCA' || $objattr['btype'] == 'UPCE' || $objattr['btype'] == 'EAN8') {
                    $this->WriteBarcode($objattr['code'], $objattr['showtext'], $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'], 0, 0, 0, 0, 0, $objattr['bheight'], $bgcol, $col, $objattr['btype'], $objattr['bsupp'], $objattr['bsupp_code'], $k);
                } // QR-code
                else if ($objattr['btype'] == 'QR') {
                    if (!class_exists('QRcode', false)) {
                        include(_MPDF_PATH . 'qrcode/qrcode.class.php');
                    }
                    $this->qrcode = new QRcode($objattr['code'], $objattr['errorlevel']);
                    $this->qrcode->displayFPDF($this, $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'] * 25, array(255, 255, 255), array(0, 0, 0));
                } else {
                    $this->WriteBarcode2($objattr['code'], $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'], $objattr['bheight'], $bgcol, $col, $objattr['btype'], $objattr['pr_ratio'], $k);
                }
            }
            /*-- END BARCODES --*/

            // TEXT CIRCLE
            if ($objattr['type'] == 'textcircle') {
                $bgcol = '';    // mPDF 5.5.14
                if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
                    $bgcol = $objattr['bgcolor'];
                }
                $col = $this->ConvertColor(0);
                if (isset($objattr['color']) && $objattr['color']) {
                    $col = $objattr['color'];
                }
                $this->SetTColor($col);
                $this->SetFColor($bgcol);
                if ($bgcol) $this->Rect($objattr['BORDER-X'], $objattr['BORDER-Y'], $objattr['BORDER-WIDTH'], $objattr['BORDER-HEIGHT'], 'F');    // mPDF 5.5.14
                $this->SetFColor($this->ConvertColor(255));
                if (isset($objattr['BORDER-WIDTH'])) {
                    $this->PaintImgBorder($objattr, $is_table);
                }
                if (!class_exists('directw', false)) {
                    include(_MPDF_PATH . 'classes/directw.php');
                }
                if (empty($this->directw)) {
                    $this->directw = new directw($this);
                }
                $save_lmfs = $this->linemaxfontsize;
                $this->linemaxfontsize = 0;
                if (isset($objattr['top-text'])) {
                    $this->directw->CircularText($objattr['INNER-X'] + $objattr['INNER-WIDTH'] / 2, $objattr['INNER-Y'] + $objattr['INNER-HEIGHT'] / 2, $objattr['r'] / $k, $objattr['top-text'], 'top', $objattr['fontfamily'], $objattr['fontsize'] / $k, $objattr['fontstyle'], $objattr['space-width'], $objattr['char-width'], $objattr['divider']);        // mPDF 5.5.23
                }
                if (isset($objattr['bottom-text'])) {
                    $this->directw->CircularText($objattr['INNER-X'] + $objattr['INNER-WIDTH'] / 2, $objattr['INNER-Y'] + $objattr['INNER-HEIGHT'] / 2, $objattr['r'] / $k, $objattr['bottom-text'], 'bottom', $objattr['fontfamily'], $objattr['fontsize'] / $k, $objattr['fontstyle'], $objattr['space-width'], $objattr['char-width'], $objattr['divider']);        // mPDF 5.5.23
                }
                $this->linemaxfontsize = $save_lmfs;
            }

            $this->ResetSpacing();

            // DOT-TAB
            if ($objattr['type'] == 'dottab') {
                // mPDF 5.6.19
                if (isset($objattr['fontfamily'])) {
                    $this->SetFont($objattr['fontfamily'], '', $objattr['fontsize']);
                }
                $sp = $this->GetStringWidth(' ');
                $nb = floor(($w - 2 * $sp) / $this->GetStringWidth('.'));
                if ($nb > 0) {
                    $dots = ' ' . str_repeat('.', $nb) . ' ';
                } else {
                    $dots = ' ';
                }
                $col = $this->ConvertColor(0);
                if (isset($objattr['colorarray']) && ($objattr['colorarray'])) {    // mPDF 5.6.19
                    $col = $objattr['colorarray'];
                }
                $this->SetTColor($col);
                $save_dh = $this->divheight;    // mPDF 5.6.19
                $save_sbd = $this->spanborddet;
                $save_u = $this->U;
                $save_s = $this->strike;
                $this->spanborddet = '';
                $this->divheight = 0;    // mPDF 5.6.19
                $this->U = false;
                $this->strike = false;
                $this->Cell($w, $h, $dots, 0, 0, 'C');
                $this->spanborddet = $save_sbd;
                $this->U = $save_u;
                $this->strike = $save_s;
                $this->divheight = $save_dh;    // mPDF 5.6.19
                // mPDF 5.0
                $this->SetTColor($this->ConvertColor(0));
            }

            /*-- FORMS --*/
            // TEXT/PASSWORD INPUT
            if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'TEXT' || $objattr['subtype'] == 'PASSWORD')) {
                $this->form->print_ob_text($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
            }

            // TEXTAREA
            if ($objattr['type'] == 'textarea') {
                $this->form->print_ob_textarea($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
            }

            // SELECT
            if ($objattr['type'] == 'select') {
                $this->form->print_ob_select($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
            }


            // INPUT/BUTTON as IMAGE
            if ($objattr['type'] == 'input' && $objattr['subtype'] == 'IMAGE') {
                $this->form->print_ob_imageinput($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
            }

            // BUTTON
            if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'SUBMIT' || $objattr['subtype'] == 'RESET' || $objattr['subtype'] == 'BUTTON')) {
                $this->form->print_ob_button($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
            }

            // CHECKBOX
            if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'CHECKBOX')) {
                $this->form->print_ob_checkbox($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir, $x, $y);
            }
            // RADIO
            if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'RADIO')) {
                $this->form->print_ob_radio($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir, $x, $y);
            }
            /*-- END FORMS --*/
        }
        $this->SetFont($save_currentfontfamily, $save_currentfontstyle, $save_currentfontsize);
        $this->y = $save_y;
        $this->x = $save_x;
        unset($content);
    }

    function Bookmark($txt, $level = 0, $y = 0)
    {
        $txt = $this->purify_utf8_text($txt);
        if ($this->text_input_as_HTML) {
            $txt = $this->all_entities_to_utf8($txt);
        }
        if ($y == -1) {
            if (!$this->ColActive) {
                $y = $this->y;
            } else {
                $y = $this->y0;
            }    // If columns are on - mark top of columns
        }
        // else y is used as set, or =0 i.e. top of page
        // DIRECTIONALITY RTL
        $bmo = array('t' => $txt, 'l' => $level, 'y' => $y, 'p' => $this->page);
        if ($this->keep_block_together) {
            $this->ktBMoutlines[] = $bmo;
        } /*-- TABLES --*/
        else if ($this->table_rotate) {
            $this->tbrot_BMoutlines[] = $bmo;
        } else if ($this->kwt) {
            $this->kwt_BMoutlines[] = $bmo;
        } /*-- END TABLES --*/
        else if ($this->ColActive) {    // *COLUMNS*
            $this->col_BMoutlines[] = $bmo;    // *COLUMNS*
        }    // *COLUMNS*
        else {
            $this->BMoutlines[] = $bmo;
        }
    }


    /*-- CJK-FONTS --*/

// from class PDF_Chinese CJK EXTENSIONS

    function purify_utf8_text($txt)
    {
        // For TEXT
        // Make sure UTF-8 string of characters
        if (!$this->is_utf8($txt)) {
            $this->Error("Text contains invalid UTF-8 character(s)");
        }

        $txt = preg_replace("/\r/", "", $txt);

        return ($txt);
    }

    /*-- END CJK-FONTS --*/

    function is_utf8(&$string)
    {
        if ($string === mb_convert_encoding(mb_convert_encoding($string, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
            return true;
        } else {
            if ($this->ignore_invalid_utf8) {
                $string = mb_convert_encoding(mb_convert_encoding($string, "UTF-32", "UTF-8"), "UTF-8", "UTF-32");
                return true;
            } else {
                return false;
            }
        }
    }

    function all_entities_to_utf8($txt)
    {
        // converts txt_entities > ASCII 127 to UTF-8
        // Leaves in particular &lt; to distinguish from tag marker
        $txt = $this->SubstituteHiEntities($txt);

        // converts all &#nnn; or &#xHHH; to UTF-8 multibyte
        $txt = strcode2utf($txt);

        $txt = $this->lesser_entity_decode($txt);
        return ($txt);
    }

    function SubstituteHiEntities($html)
    {
        // converts html_entities > ASCII 127 to unicode
        // Leaves in particular &lt; to distinguish from tag marker
        if (count($this->entsearch)) {
            $html = str_replace($this->entsearch, $this->entsubstitute, $html);
        }
        return $html;
    }

    function lesser_entity_decode($html)
    {
        //supports the most used entity codes (only does ascii safe characters)
        //$html = str_replace("&nbsp;"," ",$html);	// mPDF 5.3.59
        $html = str_replace("&lt;", "<", $html);
        $html = str_replace("&gt;", ">", $html);

        $html = str_replace("&apos;", "'", $html);
        $html = str_replace("&quot;", '"', $html);
        $html = str_replace("&amp;", "&", $html);
        return $html;
    }

    function IndexEntry($txt, $xref = '')
    {
        if ($xref) {
            $this->IndexEntrySee($txt, $xref);
            return;
        }
        $txt = strip_tags($txt);
        $txt = $this->purify_utf8_text($txt);
        if ($this->text_input_as_HTML) {
            $txt = $this->all_entities_to_utf8($txt);
        }
        if ($this->usingCoreFont) {
            $txt = mb_convert_encoding($txt, $this->mb_enc, 'UTF-8');
        }

        $Present = 0;
        $size = sizeof($this->Reference);

        if ($this->directionality == 'rtl') {    // *RTL*
            $txt = str_replace(':', ' - ', $txt);    // *RTL*
        }    // *RTL*
        else {    // *RTL*
            $txt = str_replace(':', ', ', $txt);
        }    // *RTL*


        //Search the reference (AND Ref/PageNo) in the array
        for ($i = 0; $i < $size; $i++) {
            if ($this->keep_block_together) {
                if (isset($this->ktReference[$i]['t']) && $this->ktReference[$i]['t'] == $txt) {
                    $Present = 1;
                    if ($this->page != $this->ktReference[$i]['op']) {    // mPDF 5.7.2
                        $this->ktReference[$i]['op'] = $this->page;
                    }
                }
            } /*-- TABLES --*/
            else if ($this->table_rotate) {
                if (isset($this->tbrot_Reference[$i]['t']) && $this->tbrot_Reference[$i]['t'] == $txt) {
                    $Present = 1;
                    if ($this->page != $this->tbrot_Reference[$i]['op']) {    // mPDF 5.7.2
                        $this->tbrot_Reference[$i]['op'] = $this->page;
                    }
                }
            } else if ($this->kwt) {
                if (isset($this->kwt_Reference[$i]['t']) && $this->kwt_Reference[$i]['t'] == $txt) {
                    $Present = 1;
                    if ($this->page != $this->kwt_Reference[$i]['op']) {    // mPDF 5.7.2
                        $this->kwt_Reference[$i]['op'] = $this->page;
                    }
                }
            }
            /*-- END TABLES --*/
            /*-- COLUMNS --*/
            else if ($this->ColActive) {
                if (isset($this->col_Reference[$i]['t']) && $this->col_Reference[$i]['t'] == $txt) {
                    $Present = 1;
                    if ($this->page != $this->col_Reference[$i]['op']) {    // mPDF 5.7.2
                        $this->col_Reference[$i]['op'] = $this->page;
                    }
                }
            } /*-- END COLUMNS --*/
            else {
                if (isset($this->Reference[$i]['t']) && $this->Reference[$i]['t'] == $txt) {
                    $Present = 1;
                    if (!in_array($this->page, $this->Reference[$i]['p'])) {
                        $this->Reference[$i]['p'][] = $this->page;
                    }
                }
            }
        }
        //If not found, add it
        if ($Present == 0) {
            $opr = array('t' => $txt, 'op' => $this->page);
            if ($this->keep_block_together) {
                $this->ktReference[] = $opr;
            } /*-- TABLES --*/
            else if ($this->table_rotate) {
                $this->tbrot_Reference[] = $opr;
            } else if ($this->kwt) {
                $this->kwt_Reference[] = $opr;
            }
            /*-- END TABLES --*/
            /*-- COLUMNS --*/
            else if ($this->ColActive) {
                $this->col_Reference[] = $opr;
            } /*-- END COLUMNS --*/
            else {
                $this->Reference[] = array('t' => $txt, 'p' => array($this->page));
            }
        }
    }

// Inactive function left for backwards compatability

    function IndexEntrySee($txta, $txtb)
    {
        $txta = strip_tags($txta);
        $txtb = strip_tags($txtb);
        $txta = $this->purify_utf8_text($txta);
        $txtb = $this->purify_utf8_text($txtb);
        if ($this->text_input_as_HTML) {
            $txta = $this->all_entities_to_utf8($txta);
            $txtb = $this->all_entities_to_utf8($txtb);
        }
        if ($this->usingCoreFont) {
            $txta = mb_convert_encoding($txta, $this->mb_enc, 'UTF-8');
            $txtb = mb_convert_encoding($txtb, $this->mb_enc, 'UTF-8');
        }
        if ($this->directionality == 'rtl') {    // *RTL*
            $txta = str_replace(':', ' - ', $txta);    // *RTL*
            $txtb = str_replace(':', ' - ', $txtb);    // *RTL*
        }    // *RTL*
        else {    // *RTL*
            $txta = str_replace(':', ', ', $txta);
            $txtb = str_replace(':', ', ', $txtb);
        }    // *RTL*
        $this->Reference[] = array('t' => $txta . ' - see ' . $txtb, 'p' => array());
    }

    function TOC_Entry($txt, $level = 0, $toc_id = 0)
    {
        // mPDF 5.7.2
        if ($this->ColActive) {
            $ily = $this->y0;
        } else {
            $ily = $this->y;
        }    // use top of columns

        if (!class_exists('tocontents', false)) {
            include(_MPDF_PATH . 'classes/tocontents.php');
        }
        if (empty($this->tocontents)) {
            $this->tocontents = new tocontents($this);
        }
        $linkn = $this->AddLink();
        $uid = '__mpdfinternallink_' . $linkn;
        if ($this->keep_block_together) {
            $this->internallink[$uid] = array("Y" => $ily, "PAGE" => $this->page, "kt" => true);
        } else if ($this->table_rotate) {
            $this->internallink[$uid] = array("Y" => $ily, "PAGE" => $this->page, "tbrot" => true);
        } else if ($this->kwt) {
            $this->internallink[$uid] = array("Y" => $ily, "PAGE" => $this->page, "kwt" => true);
        } else if ($this->ColActive) {
            $this->internallink[$uid] = array("Y" => $ily, "PAGE" => $this->page, "col" => $this->CurrCol);
        } else    $this->internallink[$uid] = array("Y" => $ily, "PAGE" => $this->page);
        $this->internallink['#' . $uid] = $linkn;
        $this->SetLink($linkn, $ily, $this->page);

        /*-- RTL --*/
        if ($this->biDirectional) {
            $txt = preg_replace_callback("/([" . $this->pregRTLchars . "]+)/u", array($this, 'arabJoinPregCallback'), $txt);    // mPDF 5.7+
        }
        /*-- END RTL --*/
        if (strtoupper($toc_id) == 'ALL') {
            $toc_id = '_mpdf_all';
        } else if (!$toc_id) {
            $toc_id = 0;
        } else {
            $toc_id = strtolower($toc_id);
        }
        $btoc = array('t' => $txt, 'l' => $level, 'p' => $this->page, 'link' => $linkn, 'toc_id' => $toc_id);
        if ($this->keep_block_together) {
            $this->_kttoc[] = $btoc;
        } /*-- TABLES --*/
        else if ($this->table_rotate) {
            $this->tbrot_toc[] = $btoc;
        } else if ($this->kwt) {
            $this->kwt_toc[] = $btoc;
        } /*-- END TABLES --*/
        else if ($this->ColActive) {        // *COLUMNS*
            $this->col_toc[] = $btoc;    // *COLUMNS*
        }                        // *COLUMNS*
        else {
            $this->tocontents->_toc[] = $btoc;
        }
    }

    function AddLink()
    {
        //Create a new internal link
        $n = count($this->links) + 1;
        $this->links[$n] = array(0, 0);
        return $n;
    }

    function SetLink($link, $y = 0, $page = -1)
    {
        //Set destination of internal link
        if ($y == -1) $y = $this->y;
        if ($page == -1) $page = $this->page;
        $this->links[$link] = array($page, $y);
    }

    function Annotation($text, $x = 0, $y = 0, $icon = 'Note', $author = '', $subject = '', $opacity = 0, $colarray = false, $popup = '', $file = '')
    {
        if (is_array($colarray) && count($colarray) == 3) {
            $colarray = $this->ConvertColor('rgb(' . $colarray[0] . ',' . $colarray[1] . ',' . $colarray[2] . ')');
        }
        if ($colarray === false) {
            $colarray = $this->ConvertColor('yellow');
        }
        if ($x == 0) {
            $x = $this->x;
        }
        if ($y == 0) {
            $y = $this->y;
        }
        $page = $this->page;
        if ($page < 1) {    // Document has not been started - assume it's for first page
            $page = 1;
            if ($x == 0) {
                $x = $this->lMargin;
            }
            if ($y == 0) {
                $y = $this->tMargin;
            }
        }

        if ($this->PDFA || $this->PDFX) {
            if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
                $this->PDFAXwarnings[] = "Annotation markers cannot be semi-transparent in PDFA1-b or PDFX/1-a, so they may make underlying text unreadable. (Annotation markers moved to right margin)";
            }
            $x = ($this->w) - $this->rMargin * 0.66;
        }
        if (!$this->annotMargin) {
            $y -= $this->FontSize / 2;
        }

        if (!$opacity && $this->annotMargin) {
            $opacity = 1;
        } else if (!$opacity) {
            $opacity = $this->annotOpacity;
        }

        $an = array('txt' => $text, 'x' => $x, 'y' => $y, 'opt' => array('Icon' => $icon, 'T' => $author, 'Subj' => $subject, 'C' => $colarray, 'CA' => $opacity, 'popup' => $popup, 'file' => $file));

        if ($this->keep_block_together) {    // Save to array - don't write yet
            $this->ktAnnots[$this->page][] = $an;
            return;
        } else if ($this->table_rotate) {
            $this->tbrot_Annots[$this->page][] = $an;
            return;
        } else if ($this->kwt) {
            $this->kwt_Annots[$this->page][] = $an;
            return;
        }
        // mPDF 5.0
        if ($this->writingHTMLheader || $this->writingHTMLfooter) {
            $this->HTMLheaderPageAnnots[] = $an;
            return;
        }
        //Put an Annotation on the page
        $this->PageAnnots[$page][] = $an;
        /*-- COLUMNS --*/
        // Save cross-reference to Column buffer
        $ref = count($this->PageAnnots[$this->page]) - 1;
        $this->columnAnnots[$this->CurrCol][INTVAL($this->x)][INTVAL($this->y)] = $ref;
        /*-- END COLUMNS --*/
    }

    function BeginLayer($id)
    {
        if ($this->current_layer > 0) $this->EndLayer();
        if ($id < 1) {
            return false;
        }
        if (!isset($this->layers[$id])) {
            $this->layers[$id] = array('name' => 'Layer ' . ($id));
            if (($this->PDFA || $this->PDFX)) {
                $this->PDFAXwarnings[] = "Cannot use layers when using PDFA or PDFX";
                return '';
            } else if (!$this->PDFA && !$this->PDFX) {
                $this->pdf_version = '1.5';
            }
        }
        $this->current_layer = $id;
        $this->_out('/OCZ-index /ZI' . $id . ' BDC');

        $this->pageoutput[$this->page] = array();
    }

    function EndLayer()
    {
        if ($this->current_layer > 0) {
            $this->_out('EMCZ-index');
            $this->current_layer = 0;
        }
    }

    function SetVisibility($v)
    {
        if (($this->PDFA || $this->PDFX) && $this->visibility != 'visible') {
            $this->PDFAXwarnings[] = "Cannot set visibility to anything other than full when using PDFA or PDFX";
            return '';
        } else if (!$this->PDFA && !$this->PDFX)
            $this->pdf_version = '1.5';
        if ($this->visibility != 'visible') {
            $this->_out('EMC');
            $this->hasOC = intval($this->hasOC);    // mPDF 5.6.01
        }
        if ($v == 'printonly') {
            $this->_out('/OC /OC1 BDC');
            $this->hasOC = ($this->hasOC | 1);    // mPDF 5.6.01
        } elseif ($v == 'screenonly') {
            $this->_out('/OC /OC2 BDC');
            $this->hasOC = ($this->hasOC | 2);    // mPDF 5.6.01
        } elseif ($v == 'hidden') {
            $this->_out('/OC /OC3 BDC');
            $this->hasOC = ($this->hasOC | 4);    // mPDF 5.6.01
        } elseif ($v != 'visible')
            $this->Error('Incorrect visibility: ' . $v);
        $this->visibility = $v;
    }

    function ConvertAngle($s, $makepositive = true)
    {
        if (preg_match('/([\-]*[0-9\.]+)(deg|grad|rad)/i', $s, $m)) {
            $angle = $m[1] + 0;
            if (strtolower($m[2]) == 'deg') {
                $angle = $angle;
            } else if (strtolower($m[2]) == 'grad') {
                $angle *= (360 / 400);
            } else if (strtolower($m[2]) == 'rad') {
                $angle = rad2deg($angle);
            }
            while ($angle >= 360) {
                $angle -= 360;
            }
            while ($angle <= -360) {
                $angle += 360;
            }
            if ($makepositive) {    // always returns an angle between 0 and 360deg
                if ($angle < 0) {
                    $angle += 360;
                }
            }
        } else {
            $angle = $s + 0;
        }
        return $angle;
    }

    function transformSkew($angle_x, $angle_y, $x = '', $y = '', $returnstring = false)
    {
        if ($x === '') {
            $x = $this->x;
        }
        if ($y === '') {
            $y = $this->y;
        }
        $angle_x = -$angle_x;
        $angle_y = -$angle_y;
        $x *= _MPDFK;
        $y = ($this->h - $y) * _MPDFK;
        //calculate elements of transformation matrix
        $tm = array();
        $tm[0] = 1;
        $tm[1] = tan(deg2rad($angle_y));
        $tm[2] = tan(deg2rad($angle_x));
        $tm[3] = 1;
        $tm[4] = -$tm[2] * $y;
        $tm[5] = -$tm[1] * $x;
        //skew the coordinate system
        if ($returnstring) {
            return ($this->_transform($tm, true));
        } else {
            $this->_transform($tm);
        }
    }

    function PaintImgBorder($objattr, $is_table)
    {
        // Borders are disabled in columns - messes up the repositioning in printcolumnbuffer
        if ($this->ColActive) {
            return;
        }    // *COLUMNS*
        if ($is_table) {
            $k = $this->shrin_k;
        } else {
            $k = 1;
        }
        $h = (isset($objattr['BORDER-HEIGHT']) ? $objattr['BORDER-HEIGHT'] : 0);
        $w = (isset($objattr['BORDER-WIDTH']) ? $objattr['BORDER-WIDTH'] : 0);
        $x0 = (isset($objattr['BORDER-X']) ? $objattr['BORDER-X'] : 0);
        $y0 = (isset($objattr['BORDER-Y']) ? $objattr['BORDER-Y'] : 0);

        // BORDERS
        if ($objattr['border_top']) {
            $tbd = $objattr['border_top'];
            if (!empty($tbd['s'])) {
                $this->_setBorderLine($tbd, $k);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], '', '', 'T');
                }
                $this->Line($x0, $y0, $x0 + $w, $y0);
                // Reset Corners and Dash off
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        if ($objattr['border_left']) {
            $tbd = $objattr['border_left'];
            if (!empty($tbd['s'])) {
                $this->_setBorderLine($tbd, $k);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], '', '', 'L');
                }
                $this->Line($x0, $y0, $x0, $y0 + $h);
                // Reset Corners and Dash off
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        if ($objattr['border_right']) {
            $tbd = $objattr['border_right'];
            if (!empty($tbd['s'])) {
                $this->_setBorderLine($tbd, $k);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], '', '', 'R');
                }
                $this->Line($x0 + $w, $y0, $x0 + $w, $y0 + $h);
                // Reset Corners and Dash off
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        if ($objattr['border_bottom']) {
            $tbd = $objattr['border_bottom'];
            if (!empty($tbd['s'])) {
                $this->_setBorderLine($tbd, $k);
                if ($tbd['style'] == 'dotted' || $tbd['style'] == 'dashed') {
                    $this->_setDashBorder($tbd['style'], '', '', 'B');
                }
                $this->Line($x0, $y0 + $h, $x0 + $w, $y0 + $h);
                // Reset Corners and Dash off
                $this->SetLineJoin(2);
                $this->SetLineCap(2);
                $this->SetDash();
            }
        }
        $this->SetDash();
        $this->SetAlpha(1);
    }

//==============================================================

    function WriteBarcode($code, $showtext = 1, $x = '', $y = '', $size = 1, $border = 0, $paddingL = 1, $paddingR = 1, $paddingT = 2, $paddingB = 2, $height = 1, $bgcol = false, $col = false, $btype = 'ISBN', $supplement = '0', $supplement_code = '', $k = 1)
    {
        if (empty($code)) {
            return;
        }
        $codestr = $code;
        $code = preg_replace('/\-/', '', $code);

        if (!class_exists('PDFBarcode', false)) {
            include(_MPDF_PATH . 'classes/barcode.php');
        }
        $this->barcode = new PDFBarcode();
        if ($btype == 'ISSN' || $btype == 'ISBN') {
            $arrcode = $this->barcode->getBarcodeArray($code, 'EAN13');
        } else {
            $arrcode = $this->barcode->getBarcodeArray($code, $btype);
        }

        if ($arrcode === false) {
            $this->Error('Error in barcode string: ' . $codestr);
        }
        if ((($btype == 'EAN13' || $btype == 'ISBN' || $btype == 'ISSN') && strlen($code) == 12) || ($btype == 'UPCA' && strlen($code) == 11)
            || ($btype == 'UPCE' && strlen($code) == 11) || ($btype == 'EAN8' && strlen($code) == 7)) {
            $code .= $arrcode['checkdigit'];
            if (stristr($codestr, '-')) {
                $codestr .= '-' . $arrcode['checkdigit'];
            } else {
                $codestr .= $arrcode['checkdigit'];
            }
        }
        if ($btype == 'ISBN') {
            $codestr = 'ISBN ' . $codestr;
        }
        if ($btype == 'ISSN') {
            $codestr = 'ISSN ' . $codestr;
        }

        if (empty($x)) {
            $x = $this->x;
        }
        if (empty($y)) {
            $y = $this->y;
        }
        // set foreground color
        $prevDrawColor = $this->DrawColor;
        $prevTextColor = $this->TextColor;
        $prevFillColor = $this->FillColor;
        $lw = $this->LineWidth;
        $this->SetLineWidth(0.01);

        $size /= $k;    // in case resized in a table

        $xres = $arrcode['nom-X'] * $size;
        $llm = $arrcode['lightmL'] * $arrcode['nom-X'] * $size;    // Left Light margin
        $rlm = $arrcode['lightmR'] * $arrcode['nom-X'] * $size;    // Right Light margin

        $bcw = ($arrcode["maxw"] * $xres);    // Barcode width = Should always be 31.35mm * $size

        $fbw = $bcw + $llm + $rlm;    // Full barcode width incl. light margins
        $ow = $fbw + $paddingL + $paddingR;    // Full overall width incl. user-defined padding

        $fbwi = $fbw - 2;    // Full barcode width incl. light margins - 2mm - for isbn string

        // cf. http://www.gs1uk.org/downloads/bar_code/Bar coding getting it right.pdf
        $num_height = 3 * $size;                    // Height of numerals
        $fbh = $arrcode['nom-H'] * $size * $height;        // Full barcode height incl. numerals
        $bch = $fbh - (1.5 * $size);                    // Barcode height of bars	 (3mm for numerals)

        if (($btype == 'EAN13' && $showtext) || $btype == 'ISSN' || $btype == 'ISBN') { // Add height for ISBN string + margin from top of bars
            $tisbnm = 1.5 * $size;    // Top margin between isbn (if shown) & bars
            $codestr_fontsize = 2.1 * $size;
            $paddingT += $codestr_fontsize + $tisbnm;
        }
        $oh = $fbh + $paddingT + $paddingB;        // Full overall height incl. user-defined padding

        // PRINT border background color
        $xpos = $x;
        $ypos = $y;
        if ($col) {
            $this->SetDColor($col);
            $this->SetTColor($col);
        } else {
            $this->SetDColor($this->ConvertColor(0));
            $this->SetTColor($this->ConvertColor(0));
        }
        if ($bgcol) {
            $this->SetFColor($bgcol);
        } else {
            $this->SetFColor($this->ConvertColor(255));
        }
        if (!$bgcol && !$col) {    // fn. called directly - not via HTML
            if ($border) {
                $fillb = 'DF';
            } else {
                $fillb = 'F';
            }
            $this->Rect($xpos, $ypos, $ow, $oh, $fillb);
        }


        // PRINT BARS
        $xpos = $x + $paddingL + $llm;
        $ypos = $y + $paddingT;
        if ($col) {
            $this->SetFColor($col);
        } else {
            $this->SetFColor($this->ConvertColor(0));
        }
        if ($arrcode !== false) {
            foreach ($arrcode["bcode"] AS $v) {
                $bw = ($v["w"] * $xres);
                if ($v["t"]) {
                    // draw a vertical bar
                    $this->Rect($xpos, $ypos, $bw, $bch, 'F');
                }
                $xpos += $bw;
            }
        }


        // print text
        $prevFontFamily = $this->FontFamily;
        $prevFontStyle = $this->FontStyle;
        $prevFontSizePt = $this->FontSizePt;

        // ISBN string
        if (($btype == 'EAN13' && $showtext) || $btype == 'ISBN' || $btype == 'ISSN') {
            if ($this->onlyCoreFonts) {
                $this->SetFont('chelvetica');
            } else {
                $this->SetFont('sans');
            }

            if ($bgcol) {
                $this->SetFColor($bgcol);
            } else {
                $this->SetFColor($this->ConvertColor(255));
            }
            $this->x = $x + $paddingL + 1;    // 1mm left margin (cf. $fbwi above)
            // max width is $fbwi
            $loop = 0;
            while ($loop == 0) {
                $this->SetFontSize($codestr_fontsize * 1.4 * _MPDFK, false);    // don't write
                $sz = $this->GetStringWidth($codestr);
                if ($sz > $fbwi)
                    $codestr_fontsize -= 0.1;
                else
                    $loop++;
            }
            $this->SetFont('', '', $codestr_fontsize * 1.4 * _MPDFK, true, true);    // * 1.4 because font height is only 7/10 of given mm
            // WORD SPACING
            if ($fbwi > $sz) {
                $xtra = $fbwi - $sz;
                $charspacing = $xtra / (strlen($codestr) - 1);
                if ($charspacing) {
                    $this->_out(sprintf('BT %.3F Tc ET', $charspacing * _MPDFK));
                }
            }
            $this->y = $y + $paddingT - ($codestr_fontsize) - $tisbnm;
            $this->Cell($fbw, $codestr_fontsize, $codestr);
            if ($charspacing) {
                $this->_out('BT 0 Tc ET');
            }
        }


        // Bottom NUMERALS
        // mPDF 5.7.4
        if ($this->onlyCoreFonts) {
            $this->SetFont('ccourier');
            $fh = 1.3;
        } else {
            $this->SetFont('ocrb');
            $fh = 1.06;
        }

        $charRO = '';
        if ($btype == 'EAN13' || $btype == 'ISBN' || $btype == 'ISSN') {
            $outerfontsize = 3;    // Inner fontsize = 3
            $outerp = $xres * 4;
            $innerp = $xres * 2.5;
            $textw = ($bcw * 0.5) - $outerp - $innerp;
            $chars = 6; // number of numerals in each half
            $charLO = substr($code, 0, 1); // Left Outer
            $charLI = substr($code, 1, 6); // Left Inner
            $charRI = substr($code, 7, 6); // Right Inner
            if (!$supplement) $charRO = '>'; // Right Outer
        } else if ($btype == 'UPCA') {
            $outerfontsize = 2.3;    // Inner fontsize = 3
            $outerp = $xres * 10;
            $innerp = $xres * 2.5;
            $textw = ($bcw * 0.5) - $outerp - $innerp;
            $chars = 5;
            $charLO = substr($code, 0, 1); // Left Outer
            $charLI = substr($code, 1, 5); // Left Inner
            $charRI = substr($code, 6, 5); // Right Inner
            $charRO = substr($code, 11, 1); // Right Outer
        } else if ($btype == 'UPCE') {
            $outerfontsize = 2.3;    // Inner fontsize = 3
            $outerp = $xres * 4;
            $innerp = 0;
            $textw = ($bcw * 0.5) - $outerp - $innerp;
            $chars = 3;
            $upce_code = $arrcode['code'];
            $charLO = substr($code, 0, 1); // Left Outer
            $charLI = substr($upce_code, 0, 3); // Left Inner
            $charRI = substr($upce_code, 3, 3); // Right Inner
            $charRO = substr($code, 11, 1); // Right Outer
        } else if ($btype == 'EAN8') {
            $outerfontsize = 3;    // Inner fontsize = 3
            $outerp = $xres * 4;
            $innerp = $xres * 2.5;
            $textw = ($bcw * 0.5) - $outerp - $innerp;
            $chars = 4;
            $charLO = '<'; // Left Outer
            $charLI = substr($code, 0, 4); // Left Inner
            $charRI = substr($code, 4, 4); // Right Inner
            if (!$supplement) $charRO = '>'; // Right Outer
        }

        $this->SetFontSize(($outerfontsize / 3) * 3 * $fh * $size * _MPDFK);    // 3mm numerals (FontSize is larger to account for space above/below characters)

        if (!$this->usingCoreFont) {
            $cw = $this->_getCharWidth($this->CurrentFont['cw'], 32) * 3 * $fh * $size / 1000;
        }    // character width at 3mm
        else {
            $cw = 600 * 3 * $fh * $size / 1000;
        }    // mPDF 5.7.4

        // Outer left character
        $y_text = $y + $paddingT + $bch - ($num_height / 2);
        $y_text_outer = $y + $paddingT + $bch - ($num_height * ($outerfontsize / 3) / 2);

        $this->x = $x + $paddingL - ($cw * ($outerfontsize / 3) * 0.1); // 0.1 is correction as char does not fill full width;
        $this->y = $y_text_outer;
        $this->Cell($cw, $num_height, $charLO);

        // WORD SPACING for inner chars
        $xtra = $textw - ($cw * $chars);
        $charspacing = $xtra / ($chars - 1);
        if ($charspacing) {
            $this->_out(sprintf('BT %.3F Tc ET', $charspacing * _MPDFK));
        }

        if ($bgcol) {
            $this->SetFColor($bgcol);
        } else {
            $this->SetFColor($this->ConvertColor(255));
        }

        $this->SetFontSize(3 * $fh * $size * _MPDFK);    // 3mm numerals (FontSize is larger to account for space above/below characters)

        // Inner left half characters
        $this->x = $x + $paddingL + $llm + $outerp;
        $this->y = $y_text;
        $this->Cell($textw, $num_height, $charLI, 0, 0, '', 1);

        // Inner right half characters
        $this->x = $x + $paddingL + $llm + ($bcw * 0.5) + $innerp;
        $this->y = $y_text;
        $this->Cell($textw, $num_height, $charRI, 0, 0, '', 1);

        if ($charspacing) {
            $this->_out('BT 0 Tc ET');
        }

        // Outer Right character
        $this->SetFontSize(($outerfontsize / 3) * 3 * $fh * $size * _MPDFK);    // 3mm numerals (FontSize is larger to account for space above/below characters)

        $this->x = $x + $paddingL + $llm + $bcw + $rlm - ($cw * ($outerfontsize / 3) * 0.9); // 0.9 is correction as char does not fill full width
        $this->y = $y_text_outer;
        $this->Cell($cw * ($outerfontsize / 3), $num_height, $charRO, 0, 0, 'R');

        if ($supplement) { // EAN-2 or -5 Supplement
            // PRINT BARS
            $supparrcode = $this->barcode->getBarcodeArray($supplement_code, 'EAN' . $supplement);
            if ($supparrcode === false) {
                $this->Error('Error in barcode string (supplement): ' . $codestr . ' ' . $supplement_code);
            }
            if (strlen($supplement_code) != $supplement) {
                $this->Error('Barcode supplement incorrect: ' . $supplement_code);
            }
            $llm = $fbw - (($arrcode['lightmR'] - $supparrcode['sepM']) * $arrcode['nom-X'] * $size);    // Left Light margin
            $rlm = $arrcode['lightmR'] * $arrcode['nom-X'] * $size;    // Right Light margin

            $bcw = ($supparrcode["maxw"] * $xres);    // Barcode width = Should always be 31.35mm * $size

            $fbw = $bcw + $llm + $rlm;    // Full barcode width incl. light margins
            $ow = $fbw + $paddingL + $paddingR;    // Full overall width incl. user-defined padding
            $bch = $fbh - (1.5 * $size) - ($num_height + 0.5);        // Barcode height of bars	 (3mm for numerals)

            $xpos = $x + $paddingL + $llm;
            $ypos = $y + $paddingT + $num_height + 0.5;
            if ($col) {
                $this->SetFColor($col);
            } else {
                $this->SetFColor($this->ConvertColor(0));
            }
            if ($supparrcode !== false) {
                foreach ($supparrcode["bcode"] AS $v) {
                    $bw = ($v["w"] * $xres);
                    if ($v["t"]) {
                        // draw a vertical bar
                        $this->Rect($xpos, $ypos, $bw, $bch, 'F');
                    }
                    $xpos += $bw;
                }
            }

            // Characters
            if ($bgcol) {
                $this->SetFColor($bgcol);
            } else {
                $this->SetFColor($this->ConvertColor(255));
            }
            $this->SetFontSize(3 * $fh * $size * _MPDFK);    // 3mm numerals (FontSize is larger to account for space above/below characters)
            $this->x = $x + $paddingL + $llm;
            $this->y = $y + $paddingT;
            $this->Cell($bcw, $num_height, $supplement_code, 0, 0, 'C');

            // Outer Right character (light margin)
            $this->SetFontSize(($outerfontsize / 3) * 3 * $fh * $size * _MPDFK);    // 3mm numerals (FontSize is larger to account for space above/below characters)
            $this->x = $x + $paddingL + $llm + $bcw + $rlm - ($cw * 0.9); // 0.9 is correction as char does not fill full width
            $this->y = $y + $paddingT;
            $this->Cell($cw * ($outerfontsize / 3), $num_height, '>', 0, 0, 'R');
        }


        // Restore **************
        $this->SetFont($prevFontFamily, $prevFontStyle, $prevFontSizePt);
        $this->DrawColor = $prevDrawColor;
        $this->TextColor = $prevTextColor;
        $this->FillColor = $prevFillColor;
        $this->SetLineWidth($lw);
        $this->SetY($y);
    }

    function SetY($y)
    {
        //Set y position and reset x
        $this->x = $this->lMargin;
        if ($y >= 0)
            $this->y = $y;
        else
            $this->y = $this->h + $y;
    }

    function WriteBarcode2($code, $x = '', $y = '', $size = 1, $height = 1, $bgcol = false, $col = false, $btype = 'IMB', $print_ratio = '', $k = 1)
    {
        if (empty($code)) {
            return;
        }
        if (!class_exists('PDFBarcode', false)) {
            include(_MPDF_PATH . 'classes/barcode.php');
        }
        $this->barcode = new PDFBarcode();
        $arrcode = $this->barcode->getBarcodeArray($code, $btype, $print_ratio);

        if ($arrcode === false) {
            $this->Error('Error in barcode string: ' . $code);
        }
        if (empty($x)) {
            $x = $this->x;
        }
        if (empty($y)) {
            $y = $this->y;
        }
        $prevDrawColor = $this->DrawColor;
        $prevTextColor = $this->TextColor;
        $prevFillColor = $this->FillColor;
        $lw = $this->LineWidth;
        $this->SetLineWidth(0.01);
        $size /= $k;    // in case resized in a table
        $xres = $arrcode['nom-X'] * $size;

        if ($btype == 'IMB' || $btype == 'RM4SCC' || $btype == 'KIX' || $btype == 'POSTNET' || $btype == 'PLANET') {
            $llm = $arrcode['quietL'] / $k;    // Left Quiet margin
            $rlm = $arrcode['quietR'] / $k;    // Right Quiet margin
            $tlm = $blm = $arrcode['quietTB'] / $k;
            $height = 1;        // Overrides
        } else if (in_array($btype, array('C128A', 'C128B', 'C128C', 'EAN128A', 'EAN128B', 'EAN128C', 'C39', 'C39+', 'C39E', 'C39E+', 'S25', 'S25+', 'I25', 'I25+', 'I25B', 'I25B+', 'C93', 'MSI', 'MSI+', 'CODABAR', 'CODE11'))) {
            $llm = $arrcode['lightmL'] * $xres;    // Left Quiet margin
            $rlm = $arrcode['lightmR'] * $xres;    // Right Quiet margin
            $tlm = $blm = $arrcode['lightTB'] * $xres * $height;
        }


        $bcw = ($arrcode["maxw"] * $xres);
        $fbw = $bcw + $llm + $rlm;        // Full barcode width incl. light margins

        $bch = ($arrcode["nom-H"] * $size * $height);
        $fbh = $bch + $tlm + $blm;        // Full barcode height

        // PRINT border background color
        $xpos = $x;
        $ypos = $y;
        if ($col) {
            $this->SetDColor($col);
            $this->SetTColor($col);
        } else {
            $this->SetDColor($this->ConvertColor(0));
            $this->SetTColor($this->ConvertColor(0));
        }
        if ($bgcol) {
            $this->SetFColor($bgcol);
        } else {
            $this->SetFColor($this->ConvertColor(255));
        }

        // PRINT BARS
        if ($col) {
            $this->SetFColor($col);
        } else {
            $this->SetFColor($this->ConvertColor(0));
        }
        $xpos = $x + $llm;

        if ($arrcode !== false) {
            foreach ($arrcode["bcode"] AS $v) {
                $bw = ($v["w"] * $xres);
                if ($v["t"]) {
                    $ypos = $y + $tlm + ($bch * $v['p'] / $arrcode['maxh']);
                    $this->Rect($xpos, $ypos, $bw, ($v['h'] * $bch / $arrcode['maxh']), 'F');
                }
                $xpos += $bw;
            }
        }

        // PRINT BEARER BARS
        if ($btype == 'I25B' || $btype == 'I25B+') {
            $this->Rect($x, $y, $fbw, ($arrcode['lightTB'] * $xres * $height), 'F');
            $this->Rect($x, $y + $tlm + $bch, $fbw, ($arrcode['lightTB'] * $xres * $height), 'F');
        }

        // Restore **************
        $this->SetFont($prevFontFamily, $prevFontStyle, $prevFontSizePt);
        $this->DrawColor = $prevDrawColor;
        $this->TextColor = $prevTextColor;
        $this->FillColor = $prevFillColor;
        $this->SetLineWidth($lw);
        $this->SetY($y);
    }

    function ResetMargins()
    {
        //ReSet left, top margins
        if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation == 'P' && $this->CurOrientation == 'L') {
            if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {    // EVEN
                $this->tMargin = $this->orig_rMargin;
                $this->bMargin = $this->orig_lMargin;
            } else {    // ODD	// OR NOT MIRRORING MARGINS/FOOTERS
                $this->tMargin = $this->orig_lMargin;
                $this->bMargin = $this->orig_rMargin;
            }
            $this->lMargin = $this->DeflMargin;
            $this->rMargin = $this->DefrMargin;
            $this->MarginCorrection = 0;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
        } else if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {    // EVEN
            $this->lMargin = $this->DefrMargin;
            $this->rMargin = $this->DeflMargin;
            $this->MarginCorrection = $this->DefrMargin - $this->DeflMargin;

        } else {    // ODD	// OR NOT MIRRORING MARGINS/FOOTERS
            $this->lMargin = $this->DeflMargin;
            $this->rMargin = $this->DefrMargin;
            if ($this->mirrorMargins) {
                $this->MarginCorrection = $this->DeflMargin - $this->DefrMargin;
            }
        }
        $this->x = $this->lMargin;

    }

    function Open()
    {
        //Begin document
        if ($this->state == 0) $this->_begindoc();
    }

    function _begindoc()
    {
        //Start document
        $this->state = 1;
        $this->_out('%PDF-' . $this->pdf_version);
        $this->_out('%' . chr(226) . chr(227) . chr(207) . chr(211));    // 4 chars > 128 to show binary file
    }

    function PrintBodyBackgrounds()
    {
        $s = '';
        $clx = 0;
        $cly = 0;
        $clw = $this->w;
        $clh = $this->h;
        // If using bleed and trim margins in paged media
        if ($this->pageDim[$this->page]['outer_width_LR'] || $this->pageDim[$this->page]['outer_width_TB']) {
            $clx = $this->pageDim[$this->page]['outer_width_LR'] - $this->pageDim[$this->page]['bleedMargin'];
            $cly = $this->pageDim[$this->page]['outer_width_TB'] - $this->pageDim[$this->page]['bleedMargin'];
            $clw = $this->w - 2 * $clx;
            $clh = $this->h - 2 * $cly;
        }

        if ($this->bodyBackgroundColor) {
            $s .= 'q ' . $this->SetFColor($this->bodyBackgroundColor, true) . "\n";
            if ($this->bodyBackgroundColor{0} == 5) {    // RGBa
                $s .= $this->SetAlpha(ord($this->bodyBackgroundColor{4}) / 100, 'Normal', true, 'F') . "\n";
            } else if ($this->bodyBackgroundColor{0} == 6) {    // CMYKa
                $s .= $this->SetAlpha(ord($this->bodyBackgroundColor{5}) / 100, 'Normal', true, 'F') . "\n";
            }
            $s .= sprintf('%.3F %.3F %.3F %.3F re f Q', ($clx * _MPDFK), ($cly * _MPDFK), $clw * _MPDFK, $clh * _MPDFK) . "\n";
        }

        /*-- BACKGROUNDS --*/
        if ($this->bodyBackgroundGradient) {
            $g = $this->grad->parseBackgroundGradient($this->bodyBackgroundGradient);
            if ($g) {
                $s .= $this->grad->Gradient($clx, $cly, $clw, $clh, (isset($g['gradtype']) ? $g['gradtype'] : null), $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true);
            }
        }
        if ($this->bodyBackgroundImage) {
            if ($this->bodyBackgroundImage['gradient'] && preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $this->bodyBackgroundImage['gradient'])) {
                $g = $this->grad->parseMozGradient($this->bodyBackgroundImage['gradient']);
                if ($g) {
                    $s .= $this->grad->Gradient($clx, $cly, $clw, $clh, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true);
                }
            } else if ($this->bodyBackgroundImage['image_id']) {    // Background pattern
                $n = count($this->patterns) + 1;
                // If using resize, uses TrimBox (not including the bleed)
                list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($this->bodyBackgroundImage['orig_w'], $this->bodyBackgroundImage['orig_h'], $clw, $clh, $this->bodyBackgroundImage['resize'], $this->bodyBackgroundImage['x_repeat'], $this->bodyBackgroundImage['y_repeat']);

                $this->patterns[$n] = array('x' => $clx, 'y' => $cly, 'w' => $clw, 'h' => $clh, 'pgh' => $this->h, 'image_id' => $this->bodyBackgroundImage['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $this->bodyBackgroundImage['x_pos'], 'y_pos' => $this->bodyBackgroundImage['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $this->bodyBackgroundImage['itype']);
                if (($this->bodyBackgroundImage['opacity'] > 0 || $this->bodyBackgroundImage['opacity'] === '0') && $this->bodyBackgroundImage['opacity'] < 1) {
                    $opac = $this->SetAlpha($this->bodyBackgroundImage['opacity'], 'Normal', true);
                } else {
                    $opac = '';
                }
                $s .= sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, ($clx * _MPDFK), ($cly * _MPDFK), $clw * _MPDFK, $clh * _MPDFK) . "\n";
            }
        }
        /*-- END BACKGROUNDS --*/
        return $s;
    }

//==============================================================

    function SetColumns($NbCol, $vAlign = '', $gap = 5)
    {
// NbCol = number of columns
// CurrCol = Number of the current column starting at 0
// Called externally to set columns on/off and number
// Integer 2 upwards sets columns on to that number
// Anything less than 2 turns columns off
        if ($NbCol < 2) {    // SET COLUMNS OFF
            if ($this->ColActive) {
                $this->ColActive = 0;
                if (count($this->columnbuffer)) {
                    $this->printcolumnbuffer();
                }
                $this->NbCol = 1;
                $this->ResetMargins();
                $this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
                $this->divwidth = 0;
                $this->Ln();
            }
            $this->ColActive = 0;
            $this->columnbuffer = array();
            $this->ColDetails = array();
            $this->columnLinks = array();
            $this->columnAnnots = array();
            $this->columnForms = array();
            $this->col_Reference = array();
            $this->col_BMoutlines = array();
            $this->col_toc = array();
            $this->breakpoints = array();
        } else {    // SET COLUMNS ON
            if ($this->ColActive) {
                $this->ColActive = 0;
                if (count($this->columnbuffer)) {
                    $this->printcolumnbuffer();
                }
                $this->ResetMargins();
            }
            if (isset($this->y) && $this->y > $this->tMargin) $this->Ln();
            $this->NbCol = $NbCol;
            $this->ColGap = $gap;
            $this->divwidth = 0;
            $this->ColActive = 1;
            $this->ColumnAdjust = true;    // enables column height adjustment for the page
            $this->columnbuffer = array();
            $this->ColDetails = array();
            $this->columnLinks = array();
            $this->columnAnnots = array();
            $this->columnForms = array();
            $this->col_Reference = array();
            $this->col_BMoutlines = array();
            $this->col_toc = array();
            $this->breakpoints = array();
            if ((strtoupper($vAlign) == 'J') || (strtoupper($vAlign) == 'JUSTIFY')) {
                $vAlign = 'J';
            } else {
                $vAlign = '';
            }
            $this->colvAlign = $vAlign;
            //Save the ordinate
            $absL = $this->DeflMargin - ($gap / 2);
            $absR = $this->DefrMargin - ($gap / 2);
            $PageWidth = $this->w - $absL - $absR;    // virtual pagewidth for calculation only
            $ColWidth = (($PageWidth - ($gap * ($NbCol))) / $NbCol);
            $this->ColWidth = $ColWidth;
            /*-- RTL --*/

            if ($this->directionality == 'rtl') {
                for ($i = 0; $i < $this->NbCol; $i++) {
                    $this->ColL[$i] = $absL + ($gap / 2) + (($NbCol - ($i + 1)) * ($PageWidth / $NbCol));
                    $this->ColR[$i] = $this->ColL[$i] + $ColWidth;    // NB This is not R margin -> R pos
                }
            } else {
                /*-- END RTL --*/
                for ($i = 0; $i < $this->NbCol; $i++) {
                    $this->ColL[$i] = $absL + ($gap / 2) + ($i * ($PageWidth / $NbCol));
                    $this->ColR[$i] = $this->ColL[$i] + $ColWidth;    // NB This is not R margin -> R pos
                }
            }    // *RTL*
            $this->pgwidth = $ColWidth;
            $this->SetCol(0);
            $this->y0 = $this->y;
        }
        $this->x = $this->lMargin;
    }
//==============================================================

// Moved outside WMF as also needed for SVG

    function Ln($h = '', $collapsible = 0)
    {
// Added collapsible to allow collapsible top-margin on new page
        //Line feed; default value is last cell height
        $this->x = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'];
        if ($collapsible && ($this->y == $this->tMargin) && (!$this->ColActive)) {
            $h = 0;
        }
        if (is_string($h)) $this->y += $this->lasth;
        else $this->y += $h;
    }

    function Reset()
    {
        $this->SetTColor($this->ConvertColor(0));
        $this->SetDColor($this->ConvertColor(0));
        $this->SetFColor($this->ConvertColor(255));
        $this->SetAlpha(1);
        $this->colorarray = '';

        $this->spanbgcolorarray = '';
        $this->spanbgcolor = false;
        $this->spanborder = false;
        $this->spanborddet = array();

        $this->ResetStyles();

        $this->HREF = '';
        $this->textparam = array();
        $this->SetTextOutline();

        $this->SUP = false;
        $this->SUB = false;
        $this->strike = false;
        $this->textshadow = '';

        $this->SetFont($this->default_font, '', 0, false);
        $this->SetFontSize($this->default_font_size, false);

        $this->currentfontfamily = '';
        $this->currentfontsize = '';

        /*-- TABLES --*/
        if ($this->tableLevel) {
            $this->SetLineHeight('', $this->table_lineheight);    // *TABLES*
        } else
            /*-- END TABLES --*/
            /*-- LISTS --*/

            if ($this->listlvl && $this->list_lineheight[$this->listlvl][$this->bulletarray['occur']]) {
                $this->SetLineHeight('', $this->list_lineheight[$this->listlvl][$this->bulletarray['occur']]);    // sets default line height
            } else
                /*-- END LISTS --*/
                if (isset($this->blk[$this->blklvl]['line_height']) && $this->blk[$this->blklvl]['line_height']) {
                    $this->SetLineHeight('', $this->blk[$this->blklvl]['line_height']);    // sets default line height
                }

        $this->toupper = false;
        $this->tolower = false;
        $this->kerning = false;
        $this->lSpacingCSS = '';
        $this->wSpacingCSS = '';
        $this->fixedlSpacing = false;
        $this->minwSpacing = 0;
        $this->capitalize = false;
        $this->SetDash(); //restore to no dash
        $this->dash_on = false;
        $this->dotted_on = false;
        $this->divwidth = 0;
        $this->divheight = 0;
        $this->divalign = '';
        $this->divrevert = false;
        $this->oldy = -1;

        $bodystyle = array();
        if (isset($this->cssmgr->CSS['BODY']['FONT-STYLE'])) {
            $bodystyle['FONT-STYLE'] = $this->cssmgr->CSS['BODY']['FONT-STYLE'];
        }
        if (isset($this->cssmgr->CSS['BODY']['FONT-WEIGHT'])) {
            $bodystyle['FONT-WEIGHT'] = $this->cssmgr->CSS['BODY']['FONT-WEIGHT'];
        }
        if (isset($this->cssmgr->CSS['BODY']['COLOR'])) {
            $bodystyle['COLOR'] = $this->cssmgr->CSS['BODY']['COLOR'];
        }
        if (isset($bodystyle)) {
            $this->setCSS($bodystyle, 'BLOCK', 'BODY');
        }

    }

    function ResetStyles()
    {
        foreach (array('B', 'I', 'U', 'S') as $s) {
            $this->$s = false;
        }
        $this->currentfontstyle = '';
        $this->SetFont('', '', 0, false);
    }

    function SetTextOutline($params = array())
    {    // mPDF 5.6.07
        if (isset($params['outline-s']) && $params['outline-s']) {
            $this->SetLineWidth($params['outline-WIDTH']);
            $this->SetDColor($params['outline-COLOR']);
            $tr = ('2 Tr');
            if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) {
                $this->_out($tr);
            }
            $this->pageoutput[$this->page]['TextRendering'] = $tr;
        } else //Now resets all values
        {
            $this->SetLineWidth(0.2);
            $this->SetDColor($this->ConvertColor(0));
            $this->_SetTextRendering(0);
            $tr = ('0 Tr');
            if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) {
                $this->_out($tr);
            }
            $this->pageoutput[$this->page]['TextRendering'] = $tr;
        }
    }

    function _SetTextRendering($mode)
    {
        if (!(($mode == 0) || ($mode == 1) || ($mode == 2)))
            $this->Error("Text rendering mode should be 0, 1 or 2 (value : $mode)");
        $tr = ($mode . ' Tr');
        if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']) || $this->keep_block_together)) {
            $this->_out($tr);
        }
        $this->pageoutput[$this->page]['TextRendering'] = $tr;

    }

    function setCSS($arrayaux, $type = '', $tag = '')
    {    // type= INLINE | BLOCK | LIST // tag= BODY
        if (!is_array($arrayaux)) return; //Removes PHP Warning
        // mPDF 5.7.3  inline text-decoration parameters
        $preceeding_fontkey = $this->FontFamily . $this->FontStyle;
        $preceeding_fontsize = $this->FontSize;

        // Set font size first so that e.g. MARGIN 0.83em works on font size for this element
        if (isset($arrayaux['FONT-SIZE'])) {
            $v = $arrayaux['FONT-SIZE'];
            if (is_numeric($v[0])) {
                if ($type == 'BLOCK' && $this->blklvl > 0 && isset($this->blk[$this->blklvl - 1]['InlineProperties']) && isset($this->blk[$this->blklvl - 1]['InlineProperties']['size'])) {
                    $mmsize = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['InlineProperties']['size']);
                } else {
                    $mmsize = $this->ConvertSize($v, $this->FontSize);
                }
                $this->SetFontSize($mmsize * (_MPDFK), false); //Get size in points (pt)
            } else {
                $v = strtoupper($v);
                if (isset($this->fontsizes[$v])) {
                    $this->SetFontSize($this->fontsizes[$v] * $this->default_font_size, false);
                }
            }
            if ($tag == 'BODY') {
                $this->SetDefaultFontSize($this->FontSizePt);
            }
        }


        if ($this->useLang && !$this->usingCoreFont) {
            if (isset($arrayaux['LANG']) && $arrayaux['LANG'] && $arrayaux['LANG'] != $this->default_lang && ((strlen($arrayaux['LANG']) == 5 && $arrayaux['LANG'] != 'UTF-8') || strlen($arrayaux['LANG']) == 2)) {
                list ($coreSuitable, $mpdf_pdf_unifonts) = GetLangOpts($arrayaux['LANG'], $this->useAdobeCJK);
                if ($mpdf_pdf_unifonts) {
                    $this->RestrictUnicodeFonts($mpdf_pdf_unifonts);
                } else {
                    $this->RestrictUnicodeFonts($this->default_available_fonts);
                }
                if ($tag == 'BODY') {
                    $this->currentLang = $arrayaux['LANG'];
                    $this->default_lang = $arrayaux['LANG'];
                    if ($mpdf_pdf_unifonts) {
                        $this->default_available_fonts = $mpdf_pdf_unifonts;
                    }
                }
            } else {
                $this->RestrictUnicodeFonts($this->default_available_fonts);
            }
        }

        // FOR INLINE and BLOCK OR 'BODY'
        if (isset($arrayaux['FONT-FAMILY'])) {
            $v = $arrayaux['FONT-FAMILY'];
            //If it is a font list, get all font types
            $aux_fontlist = explode(",", $v);
            $found = 0;
            foreach ($aux_fontlist AS $f) {
                $fonttype = trim($f);
                $fonttype = preg_replace('/["\']*(.*?)["\']*/', '\\1', $fonttype);
                $fonttype = preg_replace('/ /', '', $fonttype);
                $v = strtolower(trim($fonttype));
                if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) {
                    $v = $this->fonttrans[$v];
                }
                if ((!$this->onlyCoreFonts && in_array($v, $this->available_unifonts)) ||
                    in_array($v, array('ccourier', 'ctimes', 'chelvetica')) ||
                    ($this->onlyCoreFonts && in_array($v, array('courier', 'times', 'helvetica', 'arial'))) ||
                    in_array($v, array('sjis', 'uhc', 'big5', 'gb'))) {
                    $fonttype = $v;
                    $found = 1;
                    break;
                }
            }
            if (!$found) {
                foreach ($aux_fontlist AS $f) {
                    $fonttype = trim($f);
                    $fonttype = preg_replace('/["\']*(.*?)["\']*/', '\\1', $fonttype);
                    $fonttype = preg_replace('/ /', '', $fonttype);
                    $v = strtolower(trim($fonttype));
                    if (isset($this->fonttrans[$v]) && $this->fonttrans[$v]) {
                        $v = $this->fonttrans[$v];
                    }
                    if (in_array($v, $this->sans_fonts) || in_array($v, $this->serif_fonts) || in_array($v, $this->mono_fonts)) {
                        $fonttype = $v;
                        break;
                    }
                }
            }

            if ($tag == 'BODY') {
                $this->SetDefaultFont($fonttype);
            }
            $this->SetFont($fonttype, $this->currentfontstyle, 0, false);
        } else {
            $this->SetFont($this->currentfontfamily, $this->currentfontstyle, 0, false);
        }

        foreach ($arrayaux as $k => $v) {
            if ($type != 'INLINE' && $tag != 'BODY' && $type != 'LIST') {
                switch ($k) {
                    // BORDERS
                    case 'BORDER-TOP':
                        $this->blk[$this->blklvl]['border_top'] = $this->border_details($v);
                        if ($this->blk[$this->blklvl]['border_top']['s']) {
                            $this->blk[$this->blklvl]['border'] = 1;
                        }
                        break;
                    case 'BORDER-BOTTOM':
                        $this->blk[$this->blklvl]['border_bottom'] = $this->border_details($v);
                        if ($this->blk[$this->blklvl]['border_bottom']['s']) {
                            $this->blk[$this->blklvl]['border'] = 1;
                        }
                        break;
                    case 'BORDER-LEFT':
                        $this->blk[$this->blklvl]['border_left'] = $this->border_details($v);
                        if ($this->blk[$this->blklvl]['border_left']['s']) {
                            $this->blk[$this->blklvl]['border'] = 1;
                        }
                        break;
                    case 'BORDER-RIGHT':
                        $this->blk[$this->blklvl]['border_right'] = $this->border_details($v);
                        if ($this->blk[$this->blklvl]['border_right']['s']) {
                            $this->blk[$this->blklvl]['border'] = 1;
                        }
                        break;

                    // PADDING
                    case 'PADDING-TOP':
                        $this->blk[$this->blklvl]['padding_top'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'PADDING-BOTTOM':
                        $this->blk[$this->blklvl]['padding_bottom'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'PADDING-LEFT':
                        $this->blk[$this->blklvl]['padding_left'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'PADDING-RIGHT':
                        $this->blk[$this->blklvl]['padding_right'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;

                    // MARGINS
                    case 'MARGIN-TOP':
                        $tmp = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        if (isset($this->blk[$this->blklvl]['lastbottommargin'])) {
                            if ($tmp > $this->blk[$this->blklvl]['lastbottommargin']) {
                                $tmp -= $this->blk[$this->blklvl]['lastbottommargin'];
                            } else {
                                $tmp = 0;
                            }
                        }
                        $this->blk[$this->blklvl]['margin_top'] = $tmp;
                        break;
                    case 'MARGIN-BOTTOM':
                        $this->blk[$this->blklvl]['margin_bottom'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'MARGIN-LEFT':
                        $this->blk[$this->blklvl]['margin_left'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'MARGIN-RIGHT':
                        $this->blk[$this->blklvl]['margin_right'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;

                    /*-- BORDER-RADIUS --*/
                    case 'BORDER-TOP-LEFT-RADIUS-H':
                        $this->blk[$this->blklvl]['border_radius_TL_H'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-TOP-LEFT-RADIUS-V':
                        $this->blk[$this->blklvl]['border_radius_TL_V'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-TOP-RIGHT-RADIUS-H':
                        $this->blk[$this->blklvl]['border_radius_TR_H'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-TOP-RIGHT-RADIUS-V':
                        $this->blk[$this->blklvl]['border_radius_TR_V'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-BOTTOM-LEFT-RADIUS-H':
                        $this->blk[$this->blklvl]['border_radius_BL_H'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-BOTTOM-LEFT-RADIUS-V':
                        $this->blk[$this->blklvl]['border_radius_BL_V'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-BOTTOM-RIGHT-RADIUS-H':
                        $this->blk[$this->blklvl]['border_radius_BR_H'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    case 'BORDER-BOTTOM-RIGHT-RADIUS-V':
                        $this->blk[$this->blklvl]['border_radius_BR_V'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        break;
                    /*-- END BORDER-RADIUS --*/

                    case 'BOX-SHADOW':
                        $bs = $this->cssmgr->setCSSboxshadow($v);
                        if ($bs) {
                            $this->blk[$this->blklvl]['box_shadow'] = $bs;
                        }
                        break;

                    case 'BACKGROUND-CLIP':
                        if (strtoupper($v) == 'PADDING-BOX') {
                            $this->blk[$this->blklvl]['background_clip'] = 'padding-box';
                        } else if (strtoupper($v) == 'CONTENT-BOX') {
                            $this->blk[$this->blklvl]['background_clip'] = 'content-box';
                        }    // mPDF 5.6.09
                        break;

                    case 'PAGE-BREAK-AFTER':
                        if (strtoupper($v) == 'AVOID') {
                            $this->blk[$this->blklvl]['page_break_after_avoid'] = true;
                        } else if (strtoupper($v) == 'ALWAYS' || strtoupper($v) == 'LEFT' || strtoupper($v) == 'RIGHT') {
                            $this->blk[$this->blklvl]['page_break_after'] = strtoupper($v);
                        }
                        break;

                    case 'WIDTH':
                        if (strtoupper($v) != 'AUTO') {
                            $this->blk[$this->blklvl]['css_set_width'] = $this->ConvertSize($v, $this->blk[$this->blklvl - 1]['inner_width'], $this->FontSize, false);
                        }
                        break;

                    case 'TEXT-INDENT':
                        // Left as raw value (may include 1% or 2em)
                        $this->blk[$this->blklvl]['text_indent'] = $v;
                        break;

                }//end of switch($k)
            }


            if ($type != 'INLINE' && $type != 'LIST') {    // includes BODY tag
                switch ($k) {

                    case 'MARGIN-COLLAPSE':    // Custom tag to collapse margins at top and bottom of page
                        if (strtoupper($v) == 'COLLAPSE') {
                            $this->blk[$this->blklvl]['margin_collapse'] = true;
                        }
                        break;

                    case 'LINE-HEIGHT':
                        $this->blk[$this->blklvl]['line_height'] = $this->fixLineheight($v);
                        if (!$this->blk[$this->blklvl]['line_height']) {
                            $this->blk[$this->blklvl]['line_height'] = $this->normalLineheight;
                        }
                        break;

                    case 'TEXT-ALIGN': //left right center justify
                        switch (strtoupper($v)) {
                            case 'LEFT':
                                $this->blk[$this->blklvl]['align'] = "L";
                                break;
                            case 'CENTER':
                                $this->blk[$this->blklvl]['align'] = "C";
                                break;
                            case 'RIGHT':
                                $this->blk[$this->blklvl]['align'] = "R";
                                break;
                            case 'JUSTIFY':
                                $this->blk[$this->blklvl]['align'] = "J";
                                break;
                        }
                        break;

                    /*-- BACKGROUNDS --*/
                    case 'BACKGROUND-GRADIENT':
                        if ($type == 'BLOCK') {
                            $this->blk[$this->blklvl]['gradient'] = $v;
                        }
                        break;
                    /*-- END BACKGROUNDS --*/

                    case 'DIRECTION':
                        if ($v) {
                            $this->blk[$this->blklvl]['direction'] = strtolower($v);
                        }
                        break;

                }//end of switch($k)
            }

            // FOR INLINE ONLY
            if ($type == 'INLINE' || $type == 'LIST') {
                switch ($k) {
                    case 'DISPLAY':    // Custom tag to collapse margins at top and bottom of page
                        if (strtoupper($v) == 'NONE') {
                            $this->inlineDisplayOff = true;
                        }
                        break;
                    case 'DIRECTION':
                        break;
                }//end of switch($k)
            }
            // FOR INLINE ONLY
            if ($type == 'INLINE') {
                switch ($k) {
                    // BORDERS
                    case 'BORDER-TOP':
                        $this->spanborddet['T'] = $this->border_details($v);
                        $this->spanborder = true;
                        break;
                    case 'BORDER-BOTTOM':
                        $this->spanborddet['B'] = $this->border_details($v);
                        $this->spanborder = true;
                        break;
                    case 'BORDER-LEFT':
                        $this->spanborddet['L'] = $this->border_details($v);
                        $this->spanborder = true;
                        break;
                    case 'BORDER-RIGHT':
                        $this->spanborddet['R'] = $this->border_details($v);
                        $this->spanborder = true;
                        break;
                    // mPDF 5.6.26
                    case 'VISIBILITY':    // block is set in OpenTag
                        $v = strtolower($v);
                        if ($v == 'visible' || $v == 'hidden' || $v == 'printonly' || $v == 'screenonly') {
                            $this->textparam['visibility'] = $v;
                        }
                        break;
                }//end of switch($k)
            }


            // FOR INLINE and BLOCK
            switch ($k) {
                case 'TEXT-ALIGN': //left right center justify
                    if (strtoupper($v) == 'NOJUSTIFY' && $this->blk[$this->blklvl]['align'] == "J") {
                        $this->blk[$this->blklvl]['align'] = "";
                    }
                    break;
                // bgcolor only - to stay consistent with original html2fpdf
                case 'BACKGROUND':
                case 'BACKGROUND-COLOR':
                    $cor = $this->ConvertColor($v);
                    if ($cor) {
                        if ($tag == 'BODY') {
                            $this->bodyBackgroundColor = $cor;
                        } else if ($type == 'INLINE' || $type == 'LIST') {
                            $this->spanbgcolorarray = $cor;
                            $this->spanbgcolor = true;
                        } else {
                            $this->blk[$this->blklvl]['bgcolorarray'] = $cor;
                            $this->blk[$this->blklvl]['bgcolor'] = true;
                        }
                    } else if ($type != 'INLINE' && $type != 'LIST') {
                        if ($this->ColActive || $this->keep_block_together) {
                            $this->blk[$this->blklvl]['bgcolorarray'] = $this->blk[$this->blklvl - 1]['bgcolorarray'];
                            $this->blk[$this->blklvl]['bgcolor'] = $this->blk[$this->blklvl - 1]['bgcolor'];
                        }
                    }
                    break;

                // auto | normal | none
                case 'FONT-KERNING':
                    if ((strtoupper($v) == 'NORMAL' || strtoupper($v) == 'AUTO') && $this->useKerning) {
                        $this->kerning = true;
                    } else if (strtoupper($v) == 'NONE') {
                        $this->kerning = false;
                    }
                    break;


                // normal | <length>
                case 'LETTER-SPACING':
                    $this->lSpacingCSS = $v;
                    if (($this->lSpacingCSS || $this->lSpacingCSS === '0') && strtoupper($this->lSpacingCSS) != 'NORMAL') {
                        $this->fixedlSpacing = $this->ConvertSize($this->lSpacingCSS, $this->FontSize);
                    }
                    break;

                // normal | <length>
                case 'WORD-SPACING':
                    $this->wSpacingCSS = $v;
                    if ($this->wSpacingCSS && strtoupper($this->wSpacingCSS) != 'NORMAL') {
                        $this->minwSpacing = $this->ConvertSize($this->wSpacingCSS, $this->FontSize);
                    }
                    break;

                case 'FONT-STYLE': // italic normal oblique
                    switch (strtoupper($v)) {
                        case 'ITALIC':
                        case 'OBLIQUE':
                            $this->SetStyle('I', true);
                            break;
                        case 'NORMAL':
                            $this->SetStyle('I', false);
                            break;
                    }
                    break;

                case 'FONT-WEIGHT': // normal bold //Does not support: bolder, lighter, 100..900(step value=100)
                    switch (strtoupper($v)) {
                        case 'BOLD':
                            $this->SetStyle('B', true);
                            break;
                        case 'NORMAL':
                            $this->SetStyle('B', false);
                            break;
                    }
                    break;

                case 'VERTICAL-ALIGN': //super and sub only dealt with here e.g. <SUB> and <SUP>
                    switch (strtoupper($v)) {
                        case 'SUPER':
                            $this->SUP = true;
                            $this->SUB = false;    // mPDF 5.6.07
                            // mPDF 5.7.3  inline text-decoration parameters
                            if (isset($this->textparam['text-baseline'])) {
                                $this->textparam['text-baseline'] += ($this->baselineSup) * $preceeding_fontsize;
                            } else {
                                $this->textparam['text-baseline'] = ($this->baselineSup) * $preceeding_fontsize;
                            }
                            break;
                        case 'SUB':
                            $this->SUB = true;
                            $this->SUP = false;    // mPDF 5.6.07
                            // mPDF 5.7.3  inline text-decoration parameters
                            if (isset($this->textparam['text-baseline'])) {
                                $this->textparam['text-baseline'] += ($this->baselineSub) * $preceeding_fontsize;
                            } else {
                                $this->textparam['text-baseline'] = ($this->baselineSub) * $preceeding_fontsize;
                            }
                            break;
                        case 'BASELINE':    // mPDF 5.6.07
                            $this->SUB = false;
                            $this->SUP = false;
                            // mPDF 5.7.3  inline text-decoration parameters
                            if (isset($this->textparam['text-baseline'])) {
                                unset($this->textparam['text-baseline']);
                            }
                            break;
                        // mPDF 5.7.3  inline text-decoration parameters
                        default:
                            $lh = $this->_computeLineheight($this->blk[$this->blklvl]['line_height']);
                            $sz = $this->ConvertSize($v, $lh, $this->FontSize, false);
                            $this->SUP = false;
                            $this->SUB = false;
                            if ($sz) {
                                if ($sz > 0) {
                                    $this->SUP = true;
                                } else {
                                    $this->SUB = true;
                                }
                                if (isset($this->textparam['text-baseline'])) {
                                    $this->textparam['text-baseline'] += $sz;
                                } else {
                                    $this->textparam['text-baseline'] = $sz;
                                }
                            }
                    }
                    break;

                case 'FONT-VARIANT':
                    switch (strtoupper($v)) {
                        case 'SMALL-CAPS':
                            $this->SetStyle('S', true);
                            break;
                        case 'NORMAL':
                            $this->SetStyle('S', false);
                            break;
                    }
                    break;

                case 'TEXT-TRANSFORM': // none uppercase lowercase //Does support: capitalize
                    switch (strtoupper($v)) { //Not working 100%
                        case 'CAPITALIZE':
                            $this->capitalize = true;
                            break;
                        case 'UPPERCASE':
                            $this->toupper = true;
                            break;
                        case 'LOWERCASE':
                            $this->tolower = true;
                            break;
                        case 'NONE':
                            break;
                    }
                    break;

                case 'TEXT-SHADOW':
                    $ts = $this->cssmgr->setCSStextshadow($v);
                    if ($ts) {
                        $this->textshadow = $ts;
                    }
                    break;

                case 'HYPHENS':    // mPDF 5.6.08
                    if (strtoupper($v) == 'NONE') {
                        $this->textparam['hyphens'] = 2;
                    } else if (strtoupper($v) == 'AUTO') {
                        $this->textparam['hyphens'] = 1;
                    } else if (strtoupper($v) == 'MANUAL') {
                        $this->textparam['hyphens'] = 0;
                    }
                    break;

                case 'TEXT-OUTLINE':    // mPDF 5.6.07
                    if (strtoupper($v) == 'NONE') {
                        $this->textparam['outline-s'] = false;
                    }
                    break;

                case 'TEXT-OUTLINE-WIDTH':    // mPDF 5.6.07
                case 'OUTLINE-WIDTH':
                    switch (strtoupper($v)) {
                        case 'THIN':
                            $v = '0.03em';
                            break;
                        case 'MEDIUM':
                            $v = '0.05em';
                            break;
                        case 'THICK':
                            $v = '0.07em';
                            break;
                    }
                    $w = $this->ConvertSize($v, $this->blk[$this->blklvl]['inner_width'], $this->FontSize);
                    if ($w) {
                        $this->textparam['outline-WIDTH'] = $w;
                        $this->textparam['outline-s'] = true;
                    } else {
                        $this->textparam['outline-s'] = false;
                    }
                    break;

                case 'TEXT-OUTLINE-COLOR':    // mPDF 5.6.07
                case 'OUTLINE-COLOR':
                    if (strtoupper($v) == 'INVERT') {
                        if ($this->colorarray) {
                            $cor = $this->colorarray;
                            $this->textparam['outline-COLOR'] = $this->_invertColor($cor);
                        } else {
                            $this->textparam['outline-COLOR'] = $this->ConvertColor(255);
                        }
                    } else {
                        $cor = $this->ConvertColor($v);
                        if ($cor) {
                            $this->textparam['outline-COLOR'] = $cor;
                        }
                    }
                    break;

                case 'COLOR': // font color
                    $cor = $this->ConvertColor($v);
                    if ($cor) {
                        $this->colorarray = $cor;
                        $this->SetTColor($cor);
                    }
                    break;


            }//end of switch($k)


        }//end of foreach


        // mPDF 5.7.3  inline text-decoration parameters
        // Needs to be set at the end - after vertical-align = super/sub, so that textparam['text-baseline'] is set
        if (isset($arrayaux['TEXT-DECORATION'])) {
            $v = $arrayaux['TEXT-DECORATION']; // none underline line-through (strikeout) //Does not support: overline, blink
            if (stristr($v, 'LINE-THROUGH')) {
                $this->strike = true;
                // mPDF 5.7.3  inline text-decoration parameters
                if (isset($this->textparam['text-baseline'])) {
                    $this->textparam['s-decoration']['baseline'] = $this->textparam['text-baseline'];
                } else {
                    $this->textparam['s-decoration']['baseline'] = 0;
                }
                $this->textparam['s-decoration']['fontkey'] = $this->FontFamily . $this->FontStyle;
                $this->textparam['s-decoration']['fontsize'] = $this->FontSize;
                $this->textparam['s-decoration']['color'] = strtoupper($this->TextColor);    // change 0 0 0 rg to 0 0 0 RG
            }
            if (stristr($v, 'UNDERLINE')) {
                $this->SetStyle('U', true);
                // mPDF 5.7.3  inline text-decoration parameters
                if (isset($this->textparam['text-baseline'])) {
                    $this->textparam['u-decoration']['baseline'] = $this->textparam['text-baseline'];
                } else {
                    $this->textparam['u-decoration']['baseline'] = 0;
                }
                $this->textparam['u-decoration']['fontkey'] = $this->FontFamily . $this->FontStyle;
                $this->textparam['u-decoration']['fontsize'] = $this->FontSize;
                $this->textparam['u-decoration']['color'] = strtoupper($this->TextColor);    // change 0 0 0 rg to 0 0 0 RG
            }
            if (stristr($v, 'NONE')) {
                $this->SetStyle('U', false);
                $this->strike = false;
                // mPDF 5.7.3  inline text-decoration parameters
                if (isset($this->textparam['u-decoration'])) {
                    unset($this->textparam['u-decoration']);
                }
                if (isset($this->textparam['s-decoration'])) {
                    unset($this->textparam['s-decoration']);
                }
            }
        }

    }

    function border_details($bd)
    {
        $prop = preg_split('/\s+/', trim($bd));

        if (isset($this->blk[$this->blklvl]['inner_width'])) {
            $refw = $this->blk[$this->blklvl]['inner_width'];
        } else if (isset($this->blk[$this->blklvl - 1]['inner_width'])) {
            $refw = $this->blk[$this->blklvl - 1]['inner_width'];
        } else {
            $refw = $this->w;
        }
        if (count($prop) == 1) {
            $bsize = $this->ConvertSize($prop[0], $refw, $this->FontSize, false);
            if ($bsize > 0) {
                return array('s' => 1, 'w' => $bsize, 'c' => $this->ConvertColor(0), 'style' => 'solid');
            } else {
                return array('w' => 0, 's' => 0);
            }
        } else if (count($prop) == 2) {
            // 1px solid
            if (in_array($prop[1], $this->borderstyles) || $prop[1] == 'none' || $prop[1] == 'hidden') {
                $prop[2] = '';
            } // solid #000000
            else if (in_array($prop[0], $this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden') {
                $prop[0] = '';
                $prop[1] = $prop[0];
                $prop[2] = $prop[1];
            } // 1px #000000
            else {
                $prop[1] = '';
                $prop[2] = $prop[1];
            }
        } else if (count($prop) == 3) {
            // Change #000000 1px solid to 1px solid #000000 (proper)
            if (substr($prop[0], 0, 1) == '#') {
                $tmp = $prop[0];
                $prop[0] = $prop[1];
                $prop[1] = $prop[2];
                $prop[2] = $tmp;
            } // Change solid #000000 1px to 1px solid #000000 (proper)
            else if (substr($prop[0], 1, 1) == '#') {
                $tmp = $prop[1];
                $prop[0] = $prop[2];
                $prop[1] = $prop[0];
                $prop[2] = $tmp;
            } // Change solid 1px #000000 to 1px solid #000000 (proper)
            else if (in_array($prop[0], $this->borderstyles) || $prop[0] == 'none' || $prop[0] == 'hidden') {
                $tmp = $prop[0];
                $prop[0] = $prop[1];
                $prop[1] = $tmp;
            }
        } else {
            return array();
        }
        // Size
        $bsize = $this->ConvertSize($prop[0], $refw, $this->FontSize, false);
        //color
        $coul = $this->ConvertColor($prop[2]);    // returns array
        // Style
        $prop[1] = strtolower($prop[1]);
        if (in_array($prop[1], $this->borderstyles) && $bsize > 0) {
            $on = 1;
        } else if ($prop[1] == 'hidden') {
            $on = 1;
            $bsize = 0;
            $coul = '';
        } else if ($prop[1] == 'none') {
            $on = 0;
            $bsize = 0;
            $coul = '';
        } else {
            $on = 0;
            $bsize = 0;
            $coul = '';
            $prop[1] = '';
        }
        return array('s' => $on, 'w' => $bsize, 'c' => $coul, 'style' => $prop[1]);
    }

    /*-- WATERMARK --*/
// add a watermark

    function fixLineheight($v)
    {
        $lh = false;
        if (preg_match('/^[0-9\.,]*$/', $v) && $v >= 0) {
            return ($v + 0);
        } else if (strtoupper($v) == 'NORMAL') {
            return $this->normalLineheight;
        } else {
            $tlh = $this->ConvertSize($v, $this->FontSize, $this->FontSize, true);
            if ($tlh) {
                return ($tlh . 'mm');
            }
        }
        return $this->normalLineheight;
    }

    function SetStyle($tag, $enable)
    {
        $this->$tag = $enable;
        $style = '';
        foreach (array('B', 'I', 'U', 'S') as $s) {
            if ($this->$s) {
                $style .= $s;
            }
        }
        if ($this->S && empty($this->upperCase)) {
            @include(_MPDF_PATH . 'includes/upperCase.php');
        }
        $this->currentfontstyle = $style;
        $this->SetFont('', $style, 0, false);
    }

    /*-- END WATERMARK --*/

    function _computeLineheight($lh, $fs = '')
    {
        if ($this->shrin_k > 1) {
            $k = $this->shrin_k;
        } else {
            $k = 1;
        }
        if (!$fs) {
            $fs = $this->FontSize;
        }
        if (preg_match('/mm/', $lh)) {
            return (($lh + 0.0) / $k); // convert to number
        } else if ($lh > 0) {
            return ($fs * $lh);
        } else if (isset($this->normalLineheight)) {
            return ($fs * $this->normalLineheight);
        } else return ($fs * $this->default_lineheight_correction);
    }

    function _invertColor($cor)
    {
        if ($cor[0] == 3 || $cor[0] == 5) {    // RGB
            return array(3, (255 - $cor[1]), (255 - $cor[2]), (255 - $cor[3]));
        } else if ($cor[0] == 4 || $cor[0] == 6) {    // CMYK
            return array(4, (100 - $cor[1]), (100 - $cor[2]), (100 - $cor[3]), (100 - $cor[4]));
        } else if ($cor[0] == 1) {    // Grayscale
            return array(1, (255 - $cor[1]));
        }
        // Cannot cope with non-RGB colors at present
        die('Error in _invertColor - trying to invert non-RGB color');
    }


// From Invoice

    function Footer()
    {
        /*-- CSS-PAGE --*/
        // PAGED MEDIA - CROP / CROSS MARKS from @PAGE
        if ($this->show_marks == 'CROP' || $this->show_marks == 'CROPCROSS') {
            // Show TICK MARKS
            $this->SetLineWidth(0.1);    // = 0.1 mm
            $this->SetDColor($this->ConvertColor(0));
            $l = $this->cropMarkLength;
            $m = $this->cropMarkMargin;    // Distance of crop mark from margin
            $b = $this->nonPrintMargin;    // Non-printable border at edge of paper sheet
            $ax1 = $b;
            $bx = $this->page_box['outer_width_LR'] - $m;
            $ax = max($ax1, $bx - $l);
            $cx1 = $this->w - $b;
            $dx = $this->w - $this->page_box['outer_width_LR'] + $m;
            $cx = min($cx1, $dx + $l);
            $ay1 = $b;
            $by = $this->page_box['outer_width_TB'] - $m;
            $ay = max($ay1, $by - $l);
            $cy1 = $this->h - $b;
            $dy = $this->h - $this->page_box['outer_width_TB'] + $m;
            $cy = min($cy1, $dy + $l);

            $this->Line($ax, $this->page_box['outer_width_TB'], $bx, $this->page_box['outer_width_TB']);
            $this->Line($cx, $this->page_box['outer_width_TB'], $dx, $this->page_box['outer_width_TB']);
            $this->Line($ax, $this->h - $this->page_box['outer_width_TB'], $bx, $this->h - $this->page_box['outer_width_TB']);
            $this->Line($cx, $this->h - $this->page_box['outer_width_TB'], $dx, $this->h - $this->page_box['outer_width_TB']);
            $this->Line($this->page_box['outer_width_LR'], $ay, $this->page_box['outer_width_LR'], $by);
            $this->Line($this->page_box['outer_width_LR'], $cy, $this->page_box['outer_width_LR'], $dy);
            $this->Line($this->w - $this->page_box['outer_width_LR'], $ay, $this->w - $this->page_box['outer_width_LR'], $by);
            $this->Line($this->w - $this->page_box['outer_width_LR'], $cy, $this->w - $this->page_box['outer_width_LR'], $dy);

            if ($this->printers_info) {
                $hd = date('Y-m-d H:i') . '  Page ' . $this->page . ' of {nb}';
                $this->SetTColor($this->ConvertColor(0));
                $this->SetFont('arial', '', 7.5, true, true);
                $this->x = $this->page_box['outer_width_LR'] + 1.5;
                $this->y = 1;
                $this->Cell($headerpgwidth, $this->FontSize, $hd, 0, 0, 'L', 0, '', 0, 0, 0, 'M');
                $this->SetFont($this->default_font, '', $this->original_default_font_size);
            }

        }
        if ($this->show_marks == 'CROSS' || $this->show_marks == 'CROPCROSS') {
            $this->SetLineWidth(0.1);    // = 0.1 mm
            $this->SetDColor($this->ConvertColor(0));
            $l = 14 / 2;    // longer length of the cross line (half)
            $w = 6 / 2;    // shorter width of the cross line (half)
            $r = 1.2;    // radius of circle
            $m = $this->crossMarkMargin;    // Distance of cross mark from margin
            $x1 = $this->page_box['outer_width_LR'] - $m;
            $x2 = $this->w - $this->page_box['outer_width_LR'] + $m;
            $y1 = $this->page_box['outer_width_TB'] - $m;
            $y2 = $this->h - $this->page_box['outer_width_TB'] + $m;
            // Left
            $this->Circle($x1, $this->h / 2, $r, 'S');
            $this->Line($x1 - $w, $this->h / 2, $x1 + $w, $this->h / 2);
            $this->Line($x1, $this->h / 2 - $l, $x1, $this->h / 2 + $l);
            // Right
            $this->Circle($x2, $this->h / 2, $r, 'S');
            $this->Line($x2 - $w, $this->h / 2, $x2 + $w, $this->h / 2);
            $this->Line($x2, $this->h / 2 - $l, $x2, $this->h / 2 + $l);
            // Top
            $this->Circle($this->w / 2, $y1, $r, 'S');
            $this->Line($this->w / 2, $y1 - $w, $this->w / 2, $y1 + $w);
            $this->Line($this->w / 2 - $l, $y1, $this->w / 2 + $l, $y1);
            // Bottom
            $this->Circle($this->w / 2, $y2, $r, 'S');
            $this->Line($this->w / 2, $y2 - $w, $this->w / 2, $y2 + $w);
            $this->Line($this->w / 2 - $l, $y2, $this->w / 2 + $l, $y2);
        }


        // If @page set non-HTML headers/footers named, they were not read until later in the HTML code - so now set them
        if ($this->page == 1) {
            if ($this->firstPageBoxHeader) {
                $this->headerDetails['odd'] = $this->pageheaders[$this->firstPageBoxHeader];
                $this->Header();
            }
            if ($this->firstPageBoxFooter) {
                $this->footerDetails['odd'] = $this->pagefooters[$this->firstPageBoxFooter];
            }
            $this->firstPageBoxHeader = '';
            $this->firstPageBoxFooter = '';
        }
        /*-- END CSS-PAGE --*/


        /*-- HTMLHEADERS-FOOTERS --*/
        if (($this->mirrorMargins && ($this->page % 2 == 0) && $this->HTMLFooterE) || ($this->mirrorMargins && ($this->page % 2 == 1) && $this->HTMLFooter) || (!$this->mirrorMargins && $this->HTMLFooter)) {
            $this->writeHTMLFooters();
            /*-- WATERMARK --*/
            if (($this->watermarkText) && ($this->showWatermarkText)) {
                $this->watermark($this->watermarkText, 45, 120, $this->watermarkTextAlpha);    // Watermark text
            }
            if (($this->watermarkImage) && ($this->showWatermarkImage)) {
                $this->watermarkImg($this->watermarkImage, $this->watermarkImageAlpha);    // Watermark image
            }
            /*-- END WATERMARK --*/
            return;
        }
        /*-- END HTMLHEADERS-FOOTERS --*/

        $this->processingHeader = true;
        $this->ResetMargins();    // necessary after columns
        $this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
        /*-- WATERMARK --*/
        if (($this->watermarkText) && ($this->showWatermarkText)) {
            $this->watermark($this->watermarkText, 45, 120, $this->watermarkTextAlpha);    // Watermark text
        }
        if (($this->watermarkImage) && ($this->showWatermarkImage)) {
            $this->watermarkImg($this->watermarkImage, $this->watermarkImageAlpha);    // Watermark image
        }
        /*-- END WATERMARK --*/
        $h = $this->footerDetails;
        if (count($h)) {

            if ($this->forcePortraitHeaders && $this->CurOrientation == 'L' && $this->CurOrientation != $this->DefOrientation) {
                $this->_out(sprintf('q 0 -1 1 0 0 %.3F cm ', ($this->h * _MPDFK)));
                $headerpgwidth = $this->h - $this->orig_lMargin - $this->orig_rMargin;
                if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {    // EVEN
                    $headerlmargin = $this->orig_rMargin;
                } else {
                    $headerlmargin = $this->orig_lMargin;
                }
            } else {
                $yadj = 0;
                $headerpgwidth = $this->pgwidth;
                $headerlmargin = $this->lMargin;
            }
            $this->SetY(-$this->margin_footer);

            $this->SetTColor($this->ConvertColor(0));
            $this->SUP = false;
            $this->SUB = false;
            $this->bullet = false;

            // only show pagenumber if numbering on
            $pgno = $this->docPageNum($this->page, true);

            if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {    // EVEN
                $side = 'even';
            } else {    // ODD	// OR NOT MIRRORING MARGINS/FOOTERS = DEFAULT
                $side = 'odd';
            }
            $maxfontheight = 0;
            foreach (array('L', 'C', 'R') AS $pos) {
                if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
                    if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) {
                        $hfsz = $h[$side][$pos]['font-size'];
                    } else {
                        $hfsz = $this->default_font_size;
                    }
                    $maxfontheight = max($maxfontheight, $hfsz);
                }
            }
            // LEFT-CENTER-RIGHT
            foreach (array('L', 'C', 'R') AS $pos) {
                if (isset($h[$side][$pos]['content']) && $h[$side][$pos]['content']) {
                    $hd = str_replace('{PAGENO}', $pgno, $h[$side][$pos]['content']);
                    $hd = str_replace($this->aliasNbPgGp, $this->nbpgPrefix . $this->aliasNbPgGp . $this->nbpgSuffix, $hd);
                    $hd = preg_replace_callback('/\{DATE\s+(.*?)\}/', array($this, 'date_callback'), $hd);    // mPDF 5.7
                    if (isset($h[$side][$pos]['font-family']) && $h[$side][$pos]['font-family']) {
                        $hff = $h[$side][$pos]['font-family'];
                    } else {
                        $hff = $this->original_default_font;
                    }
                    if (isset($h[$side][$pos]['font-size']) && $h[$side][$pos]['font-size']) {
                        $hfsz = $h[$side][$pos]['font-size'];
                    } else {
                        $hfsz = $this->original_default_font_size;
                    }
                    $maxfontheight = max($maxfontheight, $hfsz);
                    if (isset($h[$side][$pos]['font-style']) && $h[$side][$pos]['font-style']) {
                        $hfst = $h[$side][$pos]['font-style'];
                    } else {
                        $hfst = '';
                    }
                    if (isset($h[$side][$pos]['color']) && $h[$side][$pos]['color']) {
                        $hfcol = $h[$side][$pos]['color'];
                        $cor = $this->ConvertColor($hfcol);
                        if ($cor) {
                            $this->SetTColor($cor);
                        }
                    } else {
                        $hfcol = '';
                    }
                    $this->SetFont($hff, $hfst, $hfsz, true, true);
                    $this->x = $headerlmargin;
                    $this->y = $this->h - $this->margin_footer - ($maxfontheight / _MPDFK);
                    $hd = $this->purify_utf8_text($hd);
                    if ($this->text_input_as_HTML) {
                        $hd = $this->all_entities_to_utf8($hd);
                    }
                    // CONVERT CODEPAGE
                    if ($this->usingCoreFont) {
                        $hd = mb_convert_encoding($hd, $this->mb_enc, 'UTF-8');
                    }
                    // DIRECTIONALITY RTL
                    $this->magic_reverse_dir($hd, true, $this->directionality);    // *RTL*
                    // Font-specific ligature substitution for Indic fonts
                    if (isset($this->CurrentFont['indic']) && $this->CurrentFont['indic']) $this->ConvertIndic($hd);    // *INDIC*
                    $align = $pos;
                    if ($this->directionality == 'rtl') {
                        if ($pos == 'L') {
                            $align = 'R';
                        } else if ($pos == 'R') {
                            $align = 'L';
                        }
                    }

                    if ($pos != 'L' && (strpos($hd, $this->aliasNbPg) !== false || strpos($hd, $this->aliasNbPgGp) !== false)) {
                        if