<?php
	// Barebones CMS Language Map Modifier Widget
	// (C) 2014 CubicleSoft.  All Rights Reserved.

	if (!defined("BB_FILE"))  exit();

	require_once ROOT_PATH . "/" . SUPPORT_PATH . "/bb_functions.php";

	$bb_widget->_s = "bb_langmap_modifier";
	$bb_widget->_n = "Language Map Modifier";
	$bb_widget->_key = "";
	$bb_widget->_ver = "";

	class bb_langmap_modifier extends BB_WidgetBase
	{
		public function Init()
		{
			global $bb_widget, $bb_widget_id;

			if (!BB_IsMasterWidgetConnected($bb_widget_id, "main"))  BB_AddMasterWidget($bb_widget_id, "main");
		}

		public function Process()
		{
			global $bb_mode, $bb_widget, $bb_widget_id, $bb_admin_lang, $bb_admin_def_lang, $bb_langmap;

			if ($bb_mode == "body")
			{
				if (!isset($bb_langmap))
				{
					$bb_admin_lang = "";
					$bb_admin_def_lang = "";
					$bb_langmap = array("" => array());
				}

				ob_start();
				BB_ProcessMasterWidget($bb_widget_id . "_main");
				$bb_langmap[""][$bb_widget_id . "_main"] = ob_get_contents();

				if (defined("BB_MODE_EDIT"))  ob_end_flush();
				else  ob_end_clean();
			}
			else
			{
				BB_ProcessMasterWidget($bb_widget_id . "_main");
			}
		}

		public function PreWidget()
		{
			global $bb_widget, $bb_widget_id, $bb_account;

			if ($bb_account["type"] == "dev" || $bb_account["type"] == "design")
			{
				echo "<div>" . htmlspecialchars("BB_Translate(\"" . $bb_widget_id . "_main\")") . "</div>";
			}
		}
	}
?>