<?php
class GroupDocsViewerJava_GroupDocs {
	/**
	 * Table object
	 */
	protected $_config = null;

	/**
	 * Viewer URL
	 */
	protected $_url = '';

	/**
	 * Html frame width
	 */
	protected $_width = '100%';

	/**
	 * Html frame height
	 */
	protected $_height = '600px';

    /**
     * Default file name
     */
    protected $_defaultFileName = '';

    /**
     * Use http handlers
     */
    protected $_useHttpHandlers;

	/**
	 * Class constructor
	 * @param Array $config
	 */
	public function __construct($config = array()) {
		$this->_config = new GroupDocsViewerJava_Config();
        // Set Viewer URL
        $this->_url = (empty($config['url'])) ? $this->getConfig('url') : $config['url'];
		// Set width
		$this->_width = (empty($config['width'])) ? $this->getConfig('width') : $config['width'];
		// Set height
		$this->_height = (empty($config['height'])) ? $this->getConfig('height') : $config['height'];
        // Set default file name
        $this->_defaultFileName = (empty($config['defaultFileName'])) ? $this->getConfig('defaultFileName') : $config['defaultFileName'];
        // Use http handlers
        $this->_useHttpHandlers = (empty($config['useHttpHandlers'])) ? $this->getConfig('useHttpHandlers') : $config['useHttpHandlers'];
	}

	public function getConfig($key = null) {
		try {
			$rows = $this->_config->fetchAll();
		} catch (Zend_Db_Exception $e) {
			Logger::error("Failed to get configuration; ".$e->getMessage());
			return null;
		}
        return $rows[0][$key];
    }

	public function setConfig($values = array()) {
		$this->_config->update($values, 'id = 1');
	}

	/**
	 * Render html frame
	 */
	public function renderViewer() {
		$template = '
            <script type="text/javascript" src="{url}/assets/js/libs/jquery-1.9.1.min.js"></script>
            <script type="text/javascript" src="{url}/assets/js/libs/jquery-ui-1.10.3.min.js"></script>
            <script type="text/javascript" src="{url}/assets/js/libs/knockout-2.2.1.js"></script>
            <script type="text/javascript" src="{url}/assets/js/libs/turn.min.js"></script>
            <script type="text/javascript" src="{url}/assets/js/libs/modernizr.2.6.2.Transform2d.min.js"></script>
            <script type="text/javascript">
                if (!window.Modernizr.csstransforms) {
                    var scriptLoad = document.createElement("script");
                    scriptLoad.setAttribute("type", "text/javascript");
                    scriptLoad.setAttribute("src", "{url}/assets/js/libs/turn.html4.min.js");
                    document.getElementsByTagName("head")[0].appendChild(scriptLoad);
                }
            </script>
            <script type="text/javascript" src="{url}/assets/js/installableViewer.min.js"></script>
            <script type="text/javascript">
                $.fn.groupdocsViewer.prototype.applicationPath = "{url}/";
            </script>
            <script type="text/javascript">
                $.fn.groupdocsViewer.prototype.useHttpHandlers = {useHttpHandlers};
            </script>
            <script type="text/javascript" src="{url}/assets/js/GroupdocsViewer.all.min.js"></script>

                <link rel="stylesheet" type="text/css" href="{url}/assets/css/bootstrap.css">
                <link rel="stylesheet" type="text/css" href="{url}/assets/css/GroupdocsViewer.all.min.css">
                <link rel="stylesheet" type="text/css" href="{url}/assets/css/jquery-ui-1.10.3.dialog.min.css">
                <style type="text/css">
                    #java_groupdocs_viewer p
                    {
                        color: #737373;
                    }
                </style>
                <div id="java_groupdocs_viewer" style="width: {width}; height: {height}; overflow: hidden; position: relative;
                    margin-bottom: 20px; background-color: gray; border: 1px solid #ccc;">
                        </div>
                <script>
                            $(function () {
                                var localizedStrings = null;
                                var thumbsImageBase64Encoded = null;
                                $("#java_groupdocs_viewer").groupdocsViewer({
                                    filePath: "{defaultFileName}",
                                    docViewerId: "doc_viewer1",
                                    quality: 100,
                                    showHeader: true,
                                    showThumbnails: true,
                                    openThumbnails: true,
                                    initialZoom: 100,
                                    zoomToFitWidth: true,
                                    zoomToFitHeight: false,
                                    backgroundColor: "",
                                    showFolderBrowser: true,
                                    showPrint: true,
                                    showDownload: true,
                                    showZoom: true,
                                    showPaging: true,
                                    showViewerStyleControl: true,
                                    showSearch: true,
                                    preloadPagesCount: 0,
                                    viewerStyle: 1,
                                    supportTextSelection: true,
                                    localizedStrings: localizedStrings,
                                    thumbsImageBase64Encoded: thumbsImageBase64Encoded,
                                    showDownloadErrorsInPopup: true
                                });
                            });
                </script>
		';
        $template = str_replace('{url}', $this->_url, $template);
        $template = str_replace('{width}', $this->_width, $template);
        $template = str_replace('{height}', $this->_height, $template);
        $template = str_replace('{defaultFileName}', $this->_defaultFileName, $template);
        $template = str_replace('{useHttpHandlers}', $this->_useHttpHandlers ? 'true' : 'false', $template);

        return $template;
	}
}