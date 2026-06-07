/*!
 * FilePondPluginImageEdit 1.6.3
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined'
    ? (module.exports = factory())
    : typeof define === 'function' && define.amd
    ? define(factory)
    : ((global = global || self), (global.FilePondPluginImageEdit = factory()));
})(this, function() {
  'use strict';

  var isPreviewableImage = function isPreviewableImage(file) {
    return /^image/.test(file.type);
  };

  /**
   * Image Edit Proxy Plugin
   */
  var plugin = function plugin(_) {
    var addFilter = _.addFilter,
      utils = _.utils,
      views = _.views;
    var Type = utils.Type,
      createRoute = utils.createRoute,
      _utils$createItemAPI = utils.createItemAPI,
      createItemAPI =
        _utils$createItemAPI === void 0
          ? function(item) {
              return item;
            }
          : _utils$createItemAPI;
    var fileActionButton = views.fileActionButton;

    addFilter('SHOULD_REMOVE_ON_REVERT', function(shouldRemove, _ref) {
      var item = _ref.item,
        query = _ref.query;
      return new Promise(function(resolve) {
        var file = item.file;

        // if this file is editable it shouldn't be removed immidiately even when instant uploading
        var canEdit =
          query('GET_ALLOW_IMAGE_EDIT') &&
          query('GET_IMAGE_EDIT_ALLOW_EDIT') &&
          isPreviewableImage(file);

        // if the file cannot be edited it should be removed on revert
        resolve(!canEdit);
      });
    });

    // open editor when loading a new item
    addFilter('DID_LOAD_ITEM', function(item, _ref2) {
      var query = _ref2.query,
        dispatch = _ref2.dispatch;
      return new Promise(function(resolve, reject) {
        // if is temp or local file
        if (item.origin > 1) {
          resolve(item);
          return;
        }

        // get file reference
        var file = item.file;
        if (
          !query('GET_ALLOW_IMAGE_EDIT') ||
          !query('GET_IMAGE_EDIT_INSTANT_EDIT')
        ) {
          resolve(item);
          return;
        }

        // exit if this is not an image
        if (!isPreviewableImage(file)) {
          resolve(item);
          return;
        }

        var createEditorResponseHandler = function createEditorResponseHandler(
          item,
          resolve,
          reject
        ) {
          return function(userDidConfirm) {
            // remove item
            editRequestQueue.shift();

            // handle item
            if (userDidConfirm) {
              resolve(item);
            } else {
              reject(item);
            }

            // TODO: Fix, should not be needed to kick the internal loop in case no processes are running
            dispatch('KICK');

            // handle next item!
            requestEdit();
          };
        };

        var requestEdit = function requestEdit() {
          if (!editRequestQueue.length) return;
          var _editRequestQueue$ = editRequestQueue[0],
            item = _editRequestQueue$.item,
            resolve = _editRequestQueue$.resolve,
            reject = _editRequestQueue$.reject;

          dispatch('EDIT_ITEM', {
            id: item.id,
            handleEditorResponse: createEditorResponseHandler(
              item,
              resolve,
              reject
            )
          });
        };

        queueEditRequest({ item: item, resolve: resolve, reject: reject });

        if (editRequestQueue.length === 1) {
          requestEdit();
        }
      });
    });

    // extend item methods
    addFilter('DID_CREATE_ITEM', function(item, _ref3) {
      var query = _ref3.query,
        dispatch = _ref3.dispatch;
      item.extend('edit', function() {
        dispatch('EDIT_ITEM', { id: item.id });
      });
    });

    var editRequestQueue = [];
    var queueEditRequest = function queueEditRequest(editRequest) {
      editRequestQueue.push(editRequest);
      return editRequest;
    };

    // called for each view that is created right after the 'create' method
    addFilter('CREATE_VIEW', function(viewAPI) {
      // get reference to created view
      var is = viewAPI.is,
        view = viewAPI.view,
        query = viewAPI.query;

      if (!query('GET_ALLOW_IMAGE_EDIT')) return;

      var canShowImagePreview = query('GET_ALLOW_IMAGE_PREVIEW');

      // only run for either the file or the file info panel
      var shouldExtendView =
        (is('file-info') && !canShowImagePreview) ||
        (is('file') && canShowImagePreview);

      if (!shouldExtendView) return;

      // no editor defined, then exit
      var editor = query('GET_IMAGE_EDIT_EDITOR');
      if (!editor) return;

      // set default FilePond options and add bridge once
      if (!editor.filepondCallbackBridge) {
        editor.outputData = true;
        editor.outputFile = false;
        editor.filepondCallbackBridge = {
          onconfirm: editor.onconfirm || function() {},
          oncancel: editor.oncancel || function() {}
        };
      }

      // opens the editor, if it does not already exist, it creates the editor
      var openEditor = function openEditor(_ref4) {
        var root = _ref4.root,
          props = _ref4.props,
          action = _ref4.action;
        var id = props.id;
        var handleEditorResponse = action.handleEditorResponse;

        // update editor props that could have changed
        editor.cropAspectRatio =
          root.query('GET_IMAGE_CROP_ASPECT_RATIO') || editor.cropAspectRatio;
        editor.outputCanvasBackgroundColor =
          root.query('GET_IMAGE_TRANSFORM_CANVAS_BACKGROUND_COLOR') ||
          editor.outputCanvasBackgroundColor;

        // get item
        var item = root.query('GET_ITEM', id);
        if (!item) return;

        // file to open
        var file = item.file;

        // crop data to pass to editor
        var crop = item.getMetadata('crop');
        var cropDefault = {
          center: {
            x: 0.5,
            y: 0.5
          },

          flip: {
            horizontal: false,
            vertical: false
          },

          zoom: 1,
          rotation: 0,
          aspectRatio: null
        };

        // size data to pass to editor
        var resize = item.getMetadata('resize');

        // filter and color data to pass to editor
        var filter = item.getMetadata('filter') || null;
        var filters = item.getMetadata('filters') || null;
        var colors = item.getMetadata('colors') || null;
        var markup = item.getMetadata('markup') || null;

        // build parameters object
        var imageParameters = {
          crop: crop || cropDefault,
          size: resize
            ? {
                upscale: resize.upscale,
                mode: resize.mode,
                width: resize.size.width,
                height: resize.size.height
              }
            : null,
          filter: filters
            ? filters.id || filters.matrix
            : root.query('GET_ALLOW_IMAGE_FILTER') &&
              root.query('GET_IMAGE_FILTER_COLOR_MATRIX') &&
              !colors
            ? filter
            : null,
          color: colors,
          markup: markup
        };

        editor.onconfirm = function(_ref5) {
          var data = _ref5.data;
          var crop = data.crop,
            size = data.size,
            filter = data.filter,
            color = data.color,
            colorMatrix = data.colorMatrix,
            markup = data.markup;

          // create new metadata object
          var metadata = {};

          // append crop data
          if (crop) {
            metadata.crop = crop;
          }

          // append size data
          if (size) {
            var initialSize = (item.getMetadata('resize') || {}).size;
            var targetSize = {
              width: size.width,
              height: size.height
            };

            if (!(targetSize.width && targetSize.height) && initialSize) {
              targetSize.width = initialSize.width;
              targetSize.height = initialSize.height;
            }

            if (targetSize.width || targetSize.height) {
              metadata.resize = {
                upscale: size.upscale,
                mode: size.mode,
                size: targetSize
              };
            }
          }

          if (markup) {
            metadata.markup = markup;
          }

          // set filters and colors so we can restore them when re-editing the image
          metadata.colors = color;
          metadata.filters = filter;

          // set merged color matrix to use in preview plugin
          metadata.filter = colorMatrix;

          // update crop metadata
          item.setMetadata(metadata);

          // call
          editor.filepondCallbackBridge.onconfirm(data, createItemAPI(item));

          // used in instant edit mode
          if (!handleEditorResponse) return;
          editor.onclose = function() {
            handleEditorResponse(true);
            editor.onclose = null;
          };
        };

        editor.oncancel = function() {
          // call
          editor.filepondCallbackBridge.oncancel(createItemAPI(item));

          // used in instant edit mode
          if (!handleEditorResponse) return;
          editor.onclose = function() {
            handleEditorResponse(false);
            editor.onclose = null;
          };
        };

        editor.open(file, imageParameters);
      };

      /**
       * Image Preview related
       */

      // create the image edit plugin, but only do so if the item is an image
      var didLoadItem = function didLoadItem(_ref6) {
        var root = _ref6.root,
          props = _ref6.props;

        if (!query('GET_IMAGE_EDIT_ALLOW_EDIT')) return;
        var id = props.id;

        // try to access item
        var item = query('GET_ITEM', id);
        if (!item) return;

        // get the file object
        var file = item.file;

        // exit if this is not an image
        if (!isPreviewableImage(file)) return;

        // handle interactions
        root.ref.handleEdit = function(e) {
          e.stopPropagation();
          root.dispatch('EDIT_ITEM', { id: id });
        };

        if (canShowImagePreview) {
          // add edit button to preview
          var buttonView = view.createChildView(fileActionButton, {
            label: 'edit',
            icon: query('GET_IMAGE_EDIT_ICON_EDIT'),
            opacity: 0
          });

          // edit item classname
          buttonView.element.classList.add('filepond--action-edit-item');
          buttonView.element.dataset.align = query(
            'GET_STYLE_IMAGE_EDIT_BUTTON_EDIT_ITEM_POSITION'
          );
          buttonView.on('click', root.ref.handleEdit);

          root.ref.buttonEditItem = view.appendChildView(buttonView);
        } else {
          // view is file info
          var filenameElement = view.element.querySelector(
            '.filepond--file-info-main'
          );
          var editButton = document.createElement('button');
          editButton.className = 'filepond--action-edit-item-alt';
          editButton.innerHTML =
            query('GET_IMAGE_EDIT_ICON_EDIT') + '<span>edit</span>';
          editButton.addEventListener('click', root.ref.handleEdit);
          filenameElement.appendChild(editButton);

          root.ref.editButton = editButton;
        }
      };

      view.registerDestroyer(function(_ref7) {
        var root = _ref7.root;
        if (root.ref.buttonEditItem) {
          root.ref.buttonEditItem.off('click', root.ref.handleEdit);
        }
        if (root.ref.editButton) {
          root.ref.editButton.removeEventListener('click', root.ref.handleEdit);
        }
      });

      var routes = {
        EDIT_ITEM: openEditor,
        DID_LOAD_ITEM: didLoadItem
      };

      if (canShowImagePreview) {
        // view is file
        var didPreviewUpdate = function didPreviewUpdate(_ref8) {
          var root = _ref8.root;
          if (!root.ref.buttonEditItem) return;
          root.ref.buttonEditItem.opacity = 1;
        };

        routes.DID_IMAGE_PREVIEW_SHOW = didPreviewUpdate;
      } else {
      }

      // start writing
      view.registerWriter(createRoute(routes));
    });

    // Expose plugin options
    return {
      options: {
        // enable or disable image editing
        allowImageEdit: [true, Type.BOOLEAN],

        // location of processing button
        styleImageEditButtonEditItemPosition: ['bottom center', Type.STRING],

        // open editor when image is dropped
        imageEditInstantEdit: [false, Type.BOOLEAN],

        // allow editing
        imageEditAllowEdit: [true, Type.BOOLEAN],

        // the icon to use for the edit button
        imageEditIconEdit: [
          '<svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M8.5 17h1.586l7-7L15.5 8.414l-7 7V17zm-1.707-2.707l8-8a1 1 0 0 1 1.414 0l3 3a1 1 0 0 1 0 1.414l-8 8A1 1 0 0 1 10.5 19h-3a1 1 0 0 1-1-1v-3a1 1 0 0 1 .293-.707z" fill="currentColor" fill-rule="nonzero"/></svg>',
          Type.STRING
        ],

        // editor object
        imageEditEditor: [null, Type.OBJECT]
      }
    };
  };

  // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
  var isBrowser =
    typeof window !== 'undefined' && typeof window.document !== 'undefined';
  if (isBrowser) {
    document.dispatchEvent(
      new CustomEvent('FilePond:pluginloaded', { detail: plugin })
    );
  }

  return plugin;
});
