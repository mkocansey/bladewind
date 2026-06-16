/*!
 * FilePondPluginImageTransform 3.8.7
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined'
        ? (module.exports = factory())
        : typeof define === 'function' && define.amd
        ? define(factory)
        : ((global = global || self), (global.FilePondPluginImageTransform = factory()));
})(this, function() {
    'use strict';

    // test if file is of type image
    var isImage = function isImage(file) {
        return /^image/.test(file.type);
    };

    var getFilenameWithoutExtension = function getFilenameWithoutExtension(name) {
        return name.substr(0, name.lastIndexOf('.')) || name;
    };

    // only handles image/jpg, image/jpeg, image/png, and image/svg+xml for now
    var ExtensionMap = {
        jpeg: 'jpg',
        'svg+xml': 'svg',
    };

    var renameFileToMatchMimeType = function renameFileToMatchMimeType(filename, mimeType) {
        var name = getFilenameWithoutExtension(filename);
        var type = mimeType.split('/')[1];
        var extension = ExtensionMap[type] || type;
        return ''.concat(name, '.').concat(extension);
    };

    // returns all the valid output formats we can encode towards
    var getValidOutputMimeType = function getValidOutputMimeType(type) {
        return /jpeg|png|svg\+xml/.test(type) ? type : 'image/jpeg';
    };

    // test if file is of type image
    var isImage$1 = function isImage(file) {
        return /^image/.test(file.type);
    };

    var MATRICES = {
        1: function _() {
            return [1, 0, 0, 1, 0, 0];
        },
        2: function _(width) {
            return [-1, 0, 0, 1, width, 0];
        },
        3: function _(width, height) {
            return [-1, 0, 0, -1, width, height];
        },
        4: function _(width, height) {
            return [1, 0, 0, -1, 0, height];
        },
        5: function _() {
            return [0, 1, 1, 0, 0, 0];
        },
        6: function _(width, height) {
            return [0, 1, -1, 0, height, 0];
        },
        7: function _(width, height) {
            return [0, -1, -1, 0, height, width];
        },
        8: function _(width) {
            return [0, -1, 1, 0, 0, width];
        },
    };

    var getImageOrientationMatrix = function getImageOrientationMatrix(width, height, orientation) {
        if (orientation === -1) {
            orientation = 1;
        }
        return MATRICES[orientation](width, height);
    };

    var createVector = function createVector(x, y) {
        return { x: x, y: y };
    };

    var vectorDot = function vectorDot(a, b) {
        return a.x * b.x + a.y * b.y;
    };

    var vectorSubtract = function vectorSubtract(a, b) {
        return createVector(a.x - b.x, a.y - b.y);
    };

    var vectorDistanceSquared = function vectorDistanceSquared(a, b) {
        return vectorDot(vectorSubtract(a, b), vectorSubtract(a, b));
    };

    var vectorDistance = function vectorDistance(a, b) {
        return Math.sqrt(vectorDistanceSquared(a, b));
    };

    var getOffsetPointOnEdge = function getOffsetPointOnEdge(length, rotation) {
        var a = length;

        var A = 1.5707963267948966;
        var B = rotation;
        var C = 1.5707963267948966 - rotation;

        var sinA = Math.sin(A);
        var sinB = Math.sin(B);
        var sinC = Math.sin(C);
        var cosC = Math.cos(C);
        var ratio = a / sinA;
        var b = ratio * sinB;
        var c = ratio * sinC;

        return createVector(cosC * b, cosC * c);
    };

    var getRotatedRectSize = function getRotatedRectSize(rect, rotation) {
        var w = rect.width;
        var h = rect.height;

        var hor = getOffsetPointOnEdge(w, rotation);
        var ver = getOffsetPointOnEdge(h, rotation);

        var tl = createVector(rect.x + Math.abs(hor.x), rect.y - Math.abs(hor.y));

        var tr = createVector(rect.x + rect.width + Math.abs(ver.y), rect.y + Math.abs(ver.x));

        var bl = createVector(rect.x - Math.abs(ver.y), rect.y + rect.height - Math.abs(ver.x));

        return {
            width: vectorDistance(tl, tr),
            height: vectorDistance(tl, bl),
        };
    };

    var getImageRectZoomFactor = function getImageRectZoomFactor(imageRect, cropRect) {
        var rotation = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
        var center =
            arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : { x: 0.5, y: 0.5 };

        // calculate available space round image center position
        var cx = center.x > 0.5 ? 1 - center.x : center.x;
        var cy = center.y > 0.5 ? 1 - center.y : center.y;
        var imageWidth = cx * 2 * imageRect.width;
        var imageHeight = cy * 2 * imageRect.height;

        // calculate rotated crop rectangle size
        var rotatedCropSize = getRotatedRectSize(cropRect, rotation);

        return Math.max(rotatedCropSize.width / imageWidth, rotatedCropSize.height / imageHeight);
    };

    var getCenteredCropRect = function getCenteredCropRect(container, aspectRatio) {
        var width = container.width;
        var height = width * aspectRatio;
        if (height > container.height) {
            height = container.height;
            width = height / aspectRatio;
        }
        var x = (container.width - width) * 0.5;
        var y = (container.height - height) * 0.5;

        return {
            x: x,
            y: y,
            width: width,
            height: height,
        };
    };

    var calculateCanvasSize = function calculateCanvasSize(image, canvasAspectRatio) {
        var zoom = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

        var imageAspectRatio = image.height / image.width;

        // determine actual pixels on x and y axis
        var canvasWidth = 1;
        var canvasHeight = canvasAspectRatio;
        var imgWidth = 1;
        var imgHeight = imageAspectRatio;
        if (imgHeight > canvasHeight) {
            imgHeight = canvasHeight;
            imgWidth = imgHeight / imageAspectRatio;
        }

        var scalar = Math.max(canvasWidth / imgWidth, canvasHeight / imgHeight);
        var width = image.width / (zoom * scalar * imgWidth);
        var height = width * canvasAspectRatio;

        return {
            width: width,
            height: height,
        };
    };

    var canvasRelease = function canvasRelease(canvas) {
        canvas.width = 1;
        canvas.height = 1;
        var ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, 1, 1);
    };

    var isFlipped = function isFlipped(flip) {
        return flip && (flip.horizontal || flip.vertical);
    };

    var getBitmap = function getBitmap(image, orientation, flip) {
        if (orientation <= 1 && !isFlipped(flip)) {
            image.width = image.naturalWidth;
            image.height = image.naturalHeight;
            return image;
        }

        var canvas = document.createElement('canvas');
        var width = image.naturalWidth;
        var height = image.naturalHeight;

        // if is rotated incorrectly swap width and height
        var swapped = orientation >= 5 && orientation <= 8;
        if (swapped) {
            canvas.width = height;
            canvas.height = width;
        } else {
            canvas.width = width;
            canvas.height = height;
        }

        // draw the image but first fix orientation and set correct flip
        var ctx = canvas.getContext('2d');

        // get base transformation matrix
        if (orientation) {
            ctx.transform.apply(ctx, getImageOrientationMatrix(width, height, orientation));
        }

        if (isFlipped(flip)) {
            // flip horizontal
            // [-1, 0, 0, 1, width, 0]
            var matrix = [1, 0, 0, 1, 0, 0];
            if ((!swapped && flip.horizontal) || swapped & flip.vertical) {
                matrix[0] = -1;
                matrix[4] = width;
            }

            // flip vertical
            // [1, 0, 0, -1, 0, height]
            if ((!swapped && flip.vertical) || (swapped && flip.horizontal)) {
                matrix[3] = -1;
                matrix[5] = height;
            }

            ctx.transform.apply(ctx, matrix);
        }

        ctx.drawImage(image, 0, 0, width, height);

        return canvas;
    };

    var imageToImageData = function imageToImageData(imageElement, orientation) {
        var crop = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        var options = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
        var canvasMemoryLimit = options.canvasMemoryLimit,
            _options$background = options.background,
            background = _options$background === void 0 ? null : _options$background;

        var zoom = crop.zoom || 1;

        // fixes possible image orientation problems by drawing the image on the correct canvas
        var bitmap = getBitmap(imageElement, orientation, crop.flip);
        var imageSize = {
            width: bitmap.width,
            height: bitmap.height,
        };

        var aspectRatio = crop.aspectRatio || imageSize.height / imageSize.width;

        var canvasSize = calculateCanvasSize(imageSize, aspectRatio, zoom);

        if (canvasMemoryLimit) {
            var requiredMemory = canvasSize.width * canvasSize.height;
            if (requiredMemory > canvasMemoryLimit) {
                var scalar = Math.sqrt(canvasMemoryLimit) / Math.sqrt(requiredMemory);
                imageSize.width = Math.floor(imageSize.width * scalar);
                imageSize.height = Math.floor(imageSize.height * scalar);
                canvasSize = calculateCanvasSize(imageSize, aspectRatio, zoom);
            }
        }

        var canvas = document.createElement('canvas');

        var canvasCenter = {
            x: canvasSize.width * 0.5,
            y: canvasSize.height * 0.5,
        };

        var stage = {
            x: 0,
            y: 0,
            width: canvasSize.width,
            height: canvasSize.height,
            center: canvasCenter,
        };

        var shouldLimit = typeof crop.scaleToFit === 'undefined' || crop.scaleToFit;

        var scale =
            zoom *
            getImageRectZoomFactor(
                imageSize,
                getCenteredCropRect(stage, aspectRatio),
                crop.rotation,
                shouldLimit ? crop.center : { x: 0.5, y: 0.5 }
            );

        // start drawing
        canvas.width = Math.round(canvasSize.width / scale);
        canvas.height = Math.round(canvasSize.height / scale);

        canvasCenter.x /= scale;
        canvasCenter.y /= scale;

        var imageOffset = {
            x: canvasCenter.x - imageSize.width * (crop.center ? crop.center.x : 0.5),
            y: canvasCenter.y - imageSize.height * (crop.center ? crop.center.y : 0.5),
        };

        var ctx = canvas.getContext('2d');
        if (background) {
            ctx.fillStyle = background;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        // move to draw offset
        ctx.translate(canvasCenter.x, canvasCenter.y);
        ctx.rotate(crop.rotation || 0);

        // draw the image
        ctx.drawImage(
            bitmap,
            imageOffset.x - canvasCenter.x,
            imageOffset.y - canvasCenter.y,
            imageSize.width,
            imageSize.height
        );

        // get data from canvas
        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

        // release canvas
        canvasRelease(canvas);

        // return data
        return imageData;
    };

    /**
     * Polyfill toBlob for Edge
     */
    var IS_BROWSER = (function() {
        return typeof window !== 'undefined' && typeof window.document !== 'undefined';
    })();
    if (IS_BROWSER) {
        if (!HTMLCanvasElement.prototype.toBlob) {
            Object.defineProperty(HTMLCanvasElement.prototype, 'toBlob', {
                value: function value(callback, type, quality) {
                    var dataURL = this.toDataURL(type, quality).split(',')[1];
                    setTimeout(function() {
                        var binStr = atob(dataURL);
                        var len = binStr.length;
                        var arr = new Uint8Array(len);
                        for (var i = 0; i < len; i++) {
                            arr[i] = binStr.charCodeAt(i);
                        }
                        callback(new Blob([arr], { type: type || 'image/png' }));
                    });
                },
            });
        }
    }

    var canvasToBlob = function canvasToBlob(canvas, options) {
        var beforeCreateBlob =
            arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
        return new Promise(function(resolve) {
            var promisedImage = beforeCreateBlob ? beforeCreateBlob(canvas) : canvas;
            Promise.resolve(promisedImage).then(function(canvas) {
                canvas.toBlob(resolve, options.type, options.quality);
            });
        });
    };

    var vectorMultiply = function vectorMultiply(v, amount) {
        return createVector$1(v.x * amount, v.y * amount);
    };

    var vectorAdd = function vectorAdd(a, b) {
        return createVector$1(a.x + b.x, a.y + b.y);
    };

    var vectorNormalize = function vectorNormalize(v) {
        var l = Math.sqrt(v.x * v.x + v.y * v.y);
        if (l === 0) {
            return {
                x: 0,
                y: 0,
            };
        }
        return createVector$1(v.x / l, v.y / l);
    };

    var vectorRotate = function vectorRotate(v, radians, origin) {
        var cos = Math.cos(radians);
        var sin = Math.sin(radians);
        var t = createVector$1(v.x - origin.x, v.y - origin.y);
        return createVector$1(origin.x + cos * t.x - sin * t.y, origin.y + sin * t.x + cos * t.y);
    };

    var createVector$1 = function createVector() {
        var x = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
        var y = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
        return { x: x, y: y };
    };

    var getMarkupValue = function getMarkupValue(value, size) {
        var scalar = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;
        var axis = arguments.length > 3 ? arguments[3] : undefined;
        if (typeof value === 'string') {
            return parseFloat(value) * scalar;
        }
        if (typeof value === 'number') {
            return value * (axis ? size[axis] : Math.min(size.width, size.height));
        }
        return;
    };

    var getMarkupStyles = function getMarkupStyles(markup, size, scale) {
        var lineStyle = markup.borderStyle || markup.lineStyle || 'solid';
        var fill = markup.backgroundColor || markup.fontColor || 'transparent';
        var stroke = markup.borderColor || markup.lineColor || 'transparent';
        var strokeWidth = getMarkupValue(markup.borderWidth || markup.lineWidth, size, scale);
        var lineCap = markup.lineCap || 'round';
        var lineJoin = markup.lineJoin || 'round';
        var dashes =
            typeof lineStyle === 'string'
                ? ''
                : lineStyle
                      .map(function(v) {
                          return getMarkupValue(v, size, scale);
                      })
                      .join(',');
        var opacity = markup.opacity || 1;
        return {
            'stroke-linecap': lineCap,
            'stroke-linejoin': lineJoin,
            'stroke-width': strokeWidth || 0,
            'stroke-dasharray': dashes,
            stroke: stroke,
            fill: fill,
            opacity: opacity,
        };
    };

    var isDefined = function isDefined(value) {
        return value != null;
    };

    var getMarkupRect = function getMarkupRect(rect, size) {
        var scalar = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

        var left =
            getMarkupValue(rect.x, size, scalar, 'width') ||
            getMarkupValue(rect.left, size, scalar, 'width');
        var top =
            getMarkupValue(rect.y, size, scalar, 'height') ||
            getMarkupValue(rect.top, size, scalar, 'height');
        var width = getMarkupValue(rect.width, size, scalar, 'width');
        var height = getMarkupValue(rect.height, size, scalar, 'height');
        var right = getMarkupValue(rect.right, size, scalar, 'width');
        var bottom = getMarkupValue(rect.bottom, size, scalar, 'height');

        if (!isDefined(top)) {
            if (isDefined(height) && isDefined(bottom)) {
                top = size.height - height - bottom;
            } else {
                top = bottom;
            }
        }

        if (!isDefined(left)) {
            if (isDefined(width) && isDefined(right)) {
                left = size.width - width - right;
            } else {
                left = right;
            }
        }

        if (!isDefined(width)) {
            if (isDefined(left) && isDefined(right)) {
                width = size.width - left - right;
            } else {
                width = 0;
            }
        }

        if (!isDefined(height)) {
            if (isDefined(top) && isDefined(bottom)) {
                height = size.height - top - bottom;
            } else {
                height = 0;
            }
        }

        return {
            x: left || 0,
            y: top || 0,
            width: width || 0,
            height: height || 0,
        };
    };

    var pointsToPathShape = function pointsToPathShape(points) {
        return points
            .map(function(point, index) {
                return ''
                    .concat(index === 0 ? 'M' : 'L', ' ')
                    .concat(point.x, ' ')
                    .concat(point.y);
            })
            .join(' ');
    };

    var setAttributes = function setAttributes(element, attr) {
        return Object.keys(attr).forEach(function(key) {
            return element.setAttribute(key, attr[key]);
        });
    };

    var ns = 'http://www.w3.org/2000/svg';
    var svg = function svg(tag, attr) {
        var element = document.createElementNS(ns, tag);
        if (attr) {
            setAttributes(element, attr);
        }
        return element;
    };

    var updateRect = function updateRect(element) {
        return setAttributes(element, Object.assign({}, element.rect, element.styles));
    };

    var updateEllipse = function updateEllipse(element) {
        var cx = element.rect.x + element.rect.width * 0.5;
        var cy = element.rect.y + element.rect.height * 0.5;
        var rx = element.rect.width * 0.5;
        var ry = element.rect.height * 0.5;
        return setAttributes(
            element,
            Object.assign(
                {
                    cx: cx,
                    cy: cy,
                    rx: rx,
                    ry: ry,
                },
                element.styles
            )
        );
    };

    var IMAGE_FIT_STYLE = {
        contain: 'xMidYMid meet',
        cover: 'xMidYMid slice',
    };

    var updateImage = function updateImage(element, markup) {
        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                preserveAspectRatio: IMAGE_FIT_STYLE[markup.fit] || 'none',
            })
        );
    };

    var TEXT_ANCHOR = {
        left: 'start',
        center: 'middle',
        right: 'end',
    };

    var updateText = function updateText(element, markup, size, scale) {
        var fontSize = getMarkupValue(markup.fontSize, size, scale);
        var fontFamily = markup.fontFamily || 'sans-serif';
        var fontWeight = markup.fontWeight || 'normal';
        var textAlign = TEXT_ANCHOR[markup.textAlign] || 'start';

        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                'stroke-width': 0,
                'font-weight': fontWeight,
                'font-size': fontSize,
                'font-family': fontFamily,
                'text-anchor': textAlign,
            })
        );

        // update text
        if (element.text !== markup.text) {
            element.text = markup.text;
            element.textContent = markup.text.length ? markup.text : ' ';
        }
    };

    var updateLine = function updateLine(element, markup, size, scale) {
        setAttributes(
            element,
            Object.assign({}, element.rect, element.styles, {
                fill: 'none',
            })
        );

        var line = element.childNodes[0];
        var begin = element.childNodes[1];
        var end = element.childNodes[2];

        var origin = element.rect;

        var target = {
            x: element.rect.x + element.rect.width,
            y: element.rect.y + element.rect.height,
        };

        setAttributes(line, {
            x1: origin.x,
            y1: origin.y,
            x2: target.x,
            y2: target.y,
        });

        if (!markup.lineDecoration) return;

        begin.style.display = 'none';
        end.style.display = 'none';

        var v = vectorNormalize({
            x: target.x - origin.x,
            y: target.y - origin.y,
        });

        var l = getMarkupValue(0.05, size, scale);

        if (markup.lineDecoration.indexOf('arrow-begin') !== -1) {
            var arrowBeginRotationPoint = vectorMultiply(v, l);
            var arrowBeginCenter = vectorAdd(origin, arrowBeginRotationPoint);
            var arrowBeginA = vectorRotate(origin, 2, arrowBeginCenter);
            var arrowBeginB = vectorRotate(origin, -2, arrowBeginCenter);

            setAttributes(begin, {
                style: 'display:block;',
                d: 'M'
                    .concat(arrowBeginA.x, ',')
                    .concat(arrowBeginA.y, ' L')
                    .concat(origin.x, ',')
                    .concat(origin.y, ' L')
                    .concat(arrowBeginB.x, ',')
                    .concat(arrowBeginB.y),
            });
        }

        if (markup.lineDecoration.indexOf('arrow-end') !== -1) {
            var arrowEndRotationPoint = vectorMultiply(v, -l);
            var arrowEndCenter = vectorAdd(target, arrowEndRotationPoint);
            var arrowEndA = vectorRotate(target, 2, arrowEndCenter);
            var arrowEndB = vectorRotate(target, -2, arrowEndCenter);

            setAttributes(end, {
                style: 'display:block;',
                d: 'M'
                    .concat(arrowEndA.x, ',')
                    .concat(arrowEndA.y, ' L')
                    .concat(target.x, ',')
                    .concat(target.y, ' L')
                    .concat(arrowEndB.x, ',')
                    .concat(arrowEndB.y),
            });
        }
    };

    var updatePath = function updatePath(element, markup, size, scale) {
        setAttributes(
            element,
            Object.assign({}, element.styles, {
                fill: 'none',
                d: pointsToPathShape(
                    markup.points.map(function(point) {
                        return {
                            x: getMarkupValue(point.x, size, scale, 'width'),
                            y: getMarkupValue(point.y, size, scale, 'height'),
                        };
                    })
                ),
            })
        );
    };

    var createShape = function createShape(node) {
        return function(markup) {
            return svg(node, { id: markup.id });
        };
    };

    var createImage = function createImage(markup) {
        var shape = svg('image', {
            id: markup.id,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
            opacity: '0',
        });

        shape.onload = function() {
            shape.setAttribute('opacity', markup.opacity || 1);
        };
        shape.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', markup.src);
        return shape;
    };

    var createLine = function createLine(markup) {
        var shape = svg('g', {
            id: markup.id,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
        });

        var line = svg('line');
        shape.appendChild(line);

        var begin = svg('path');
        shape.appendChild(begin);

        var end = svg('path');
        shape.appendChild(end);

        return shape;
    };

    var CREATE_TYPE_ROUTES = {
        image: createImage,
        rect: createShape('rect'),
        ellipse: createShape('ellipse'),
        text: createShape('text'),
        path: createShape('path'),
        line: createLine,
    };

    var UPDATE_TYPE_ROUTES = {
        rect: updateRect,
        ellipse: updateEllipse,
        image: updateImage,
        text: updateText,
        path: updatePath,
        line: updateLine,
    };

    var createMarkupByType = function createMarkupByType(type, markup) {
        return CREATE_TYPE_ROUTES[type](markup);
    };

    var updateMarkupByType = function updateMarkupByType(element, type, markup, size, scale) {
        if (type !== 'path') {
            element.rect = getMarkupRect(markup, size, scale);
        }
        element.styles = getMarkupStyles(markup, size, scale);
        UPDATE_TYPE_ROUTES[type](element, markup, size, scale);
    };

    var sortMarkupByZIndex = function sortMarkupByZIndex(a, b) {
        if (a[1].zIndex > b[1].zIndex) {
            return 1;
        }
        if (a[1].zIndex < b[1].zIndex) {
            return -1;
        }
        return 0;
    };

    var cropSVG = function cropSVG(blob) {
        var crop = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var markup = arguments.length > 2 ? arguments[2] : undefined;
        var options = arguments.length > 3 ? arguments[3] : undefined;
        return new Promise(function(resolve) {
            var _options$background = options.background,
                background = _options$background === void 0 ? null : _options$background;

            // load blob contents and wrap in crop svg
            var fr = new FileReader();
            fr.onloadend = function() {
                // get svg text
                var text = fr.result;

                // create element with svg and get size
                var original = document.createElement('div');
                original.style.cssText =
                    'position:absolute;pointer-events:none;width:0;height:0;visibility:hidden;';
                original.innerHTML = text;
                var originalNode = original.querySelector('svg');
                document.body.appendChild(original);

                // request bounding box dimensions
                var bBox = originalNode.getBBox();
                original.parentNode.removeChild(original);

                // get title
                var titleNode = original.querySelector('title');

                // calculate new heights and widths
                var viewBoxAttribute = originalNode.getAttribute('viewBox') || '';
                var widthAttribute = originalNode.getAttribute('width') || '';
                var heightAttribute = originalNode.getAttribute('height') || '';
                var width = parseFloat(widthAttribute) || null;
                var height = parseFloat(heightAttribute) || null;
                var widthUnits = (widthAttribute.match(/[a-z]+/) || [])[0] || '';
                var heightUnits = (heightAttribute.match(/[a-z]+/) || [])[0] || '';

                // create new size
                var viewBoxList = viewBoxAttribute.split(' ').map(parseFloat);
                var viewBox = viewBoxList.length
                    ? {
                          x: viewBoxList[0],
                          y: viewBoxList[1],
                          width: viewBoxList[2],
                          height: viewBoxList[3],
                      }
                    : bBox;

                var imageWidth = width != null ? width : viewBox.width;
                var imageHeight = height != null ? height : viewBox.height;

                originalNode.style.overflow = 'visible';
                originalNode.setAttribute('width', imageWidth);
                originalNode.setAttribute('height', imageHeight);

                // markup
                var markupSVG = '';
                if (markup && markup.length) {
                    var size = {
                        width: imageWidth,
                        height: imageHeight,
                    };

                    markupSVG = markup.sort(sortMarkupByZIndex).reduce(function(prev, shape) {
                        var el = createMarkupByType(shape[0], shape[1]);
                        updateMarkupByType(el, shape[0], shape[1], size);
                        el.removeAttribute('id');
                        if (el.getAttribute('opacity') === 1) {
                            el.removeAttribute('opacity');
                        }
                        return prev + '\n' + el.outerHTML + '\n';
                    }, '');
                    markupSVG = '\n\n<g>'.concat(markupSVG.replace(/&nbsp;/g, ' '), '</g>\n\n');
                }

                var aspectRatio = crop.aspectRatio || imageHeight / imageWidth;

                var canvasWidth = imageWidth;
                var canvasHeight = canvasWidth * aspectRatio;

                var shouldLimit = typeof crop.scaleToFit === 'undefined' || crop.scaleToFit;

                var cropCenterX = crop.center ? crop.center.x : 0.5;
                var cropCenterY = crop.center ? crop.center.y : 0.5;

                var canvasZoomFactor = getImageRectZoomFactor(
                    {
                        width: imageWidth,
                        height: imageHeight,
                    },

                    getCenteredCropRect(
                        {
                            width: canvasWidth,
                            height: canvasHeight,
                        },

                        aspectRatio
                    ),

                    crop.rotation,
                    shouldLimit
                        ? { x: cropCenterX, y: cropCenterY }
                        : {
                              x: 0.5,
                              y: 0.5,
                          }
                );

                var scale = crop.zoom * canvasZoomFactor;

                var rotation = crop.rotation * (180 / Math.PI);

                var canvasCenter = {
                    x: canvasWidth * 0.5,
                    y: canvasHeight * 0.5,
                };

                var imageOffset = {
                    x: canvasCenter.x - imageWidth * cropCenterX,
                    y: canvasCenter.y - imageHeight * cropCenterY,
                };

                var cropTransforms = [
                    // rotate
                    'rotate('
                        .concat(rotation, ' ')
                        .concat(canvasCenter.x, ' ')
                        .concat(canvasCenter.y, ')'),

                    // scale
                    'translate('.concat(canvasCenter.x, ' ').concat(canvasCenter.y, ')'),
                    'scale('.concat(scale, ')'),
                    'translate('.concat(-canvasCenter.x, ' ').concat(-canvasCenter.y, ')'),

                    // offset
                    'translate('.concat(imageOffset.x, ' ').concat(imageOffset.y, ')'),
                ];

                var cropFlipHorizontal = crop.flip && crop.flip.horizontal;
                var cropFlipVertical = crop.flip && crop.flip.vertical;

                var flipTransforms = [
                    'scale('
                        .concat(cropFlipHorizontal ? -1 : 1, ' ')
                        .concat(cropFlipVertical ? -1 : 1, ')'),
                    'translate('
                        .concat(cropFlipHorizontal ? -imageWidth : 0, ' ')
                        .concat(cropFlipVertical ? -imageHeight : 0, ')'),
                ];

                // crop
                var transformed = '<?xml version="1.0" encoding="UTF-8"?>\n<svg width="'
                    .concat(canvasWidth)
                    .concat(widthUnits, '" height="')
                    .concat(canvasHeight)
                    .concat(heightUnits, '" \nviewBox="0 0 ')
                    .concat(canvasWidth, ' ')
                    .concat(canvasHeight, '" ')
                    .concat(
                        background ? 'style="background:' + background + '" ' : '',
                        '\npreserveAspectRatio="xMinYMin"\nxmlns:xlink="http://www.w3.org/1999/xlink"\nxmlns="http://www.w3.org/2000/svg">\n<!-- Generated by PQINA - https://pqina.nl/ -->\n<title>'
                    )
                    .concat(titleNode ? titleNode.textContent : '', '</title>\n<g transform="')
                    .concat(cropTransforms.join(' '), '">\n<g transform="')
                    .concat(flipTransforms.join(' '), '">\n')
                    .concat(originalNode.outerHTML)
                    .concat(markupSVG, '\n</g>\n</g>\n</svg>');

                // create new svg file
                resolve(transformed);
            };

            fr.readAsText(blob);
        });
    };

    var objectToImageData = function objectToImageData(obj) {
        var imageData;
        try {
            imageData = new ImageData(obj.width, obj.height);
        } catch (e) {
            // IE + Old EDGE (tested on 12)
            var canvas = document.createElement('canvas');
            imageData = canvas.getContext('2d').createImageData(obj.width, obj.height);
        }
        imageData.data.set(obj.data);
        return imageData;
    };

    /* javascript-obfuscator:disable */
    var TransformWorker = function TransformWorker() {
        // maps transform types to transform functions
        var TRANSFORMS = { resize: resize, filter: filter };

        // applies all image transforms to the image data array
        var applyTransforms = function applyTransforms(transforms, imageData) {
            transforms.forEach(function(transform) {
                imageData = TRANSFORMS[transform.type](imageData, transform.data);
            });
            return imageData;
        };

        // transform image hub
        var transform = function transform(data, cb) {
            var transforms = data.transforms;

            // if has filter and has resize, move filter to resize operation
            var filterTransform = null;
            transforms.forEach(function(transform) {
                if (transform.type === 'filter') {
                    filterTransform = transform;
                }
            });
            if (filterTransform) {
                // find resize
                var resizeTransform = null;
                transforms.forEach(function(transform) {
                    if (transform.type === 'resize') {
                        resizeTransform = transform;
                    }
                });

                if (resizeTransform) {
                    // update resize operation
                    resizeTransform.data.matrix = filterTransform.data;

                    // remove filter
                    transforms = transforms.filter(function(transform) {
                        return transform.type !== 'filter';
                    });
                }
            }

            cb(applyTransforms(transforms, data.imageData));
        };

        // eslint-disable-next-line no-restricted-globals
        self.onmessage = function(e) {
            transform(e.data.message, function(response) {
                // eslint-disable-next-line no-restricted-globals
                self.postMessage({ id: e.data.id, message: response }, [response.data.buffer]);
            });
        };

        var br = 1.0;
        var bg = 1.0;
        var bb = 1.0;
        function applyFilterMatrix(index, data, m) {
            var ir = data[index] / 255;
            var ig = data[index + 1] / 255;
            var ib = data[index + 2] / 255;
            var ia = data[index + 3] / 255;

            var mr = ir * m[0] + ig * m[1] + ib * m[2] + ia * m[3] + m[4];
            var mg = ir * m[5] + ig * m[6] + ib * m[7] + ia * m[8] + m[9];
            var mb = ir * m[10] + ig * m[11] + ib * m[12] + ia * m[13] + m[14];
            var ma = ir * m[15] + ig * m[16] + ib * m[17] + ia * m[18] + m[19];

            var or = Math.max(0, mr * ma) + br * (1.0 - ma);
            var og = Math.max(0, mg * ma) + bg * (1.0 - ma);
            var ob = Math.max(0, mb * ma) + bb * (1.0 - ma);

            data[index] = Math.max(0.0, Math.min(1.0, or)) * 255;
            data[index + 1] = Math.max(0.0, Math.min(1.0, og)) * 255;
            data[index + 2] = Math.max(0.0, Math.min(1.0, ob)) * 255;
        }

        var identityMatrix = self.JSON.stringify([
            1,
            0,
            0,
            0,
            0,
            0,
            1,
            0,
            0,
            0,
            0,
            0,
            1,
            0,
            0,
            0,
            0,
            0,
            1,
            0,
        ]);
        function isIdentityMatrix(filter) {
            return self.JSON.stringify(filter || []) === identityMatrix;
        }

        function filter(imageData, matrix) {
            if (!matrix || isIdentityMatrix(matrix)) return imageData;

            var data = imageData.data;
            var l = data.length;

            var m11 = matrix[0];
            var m12 = matrix[1];
            var m13 = matrix[2];
            var m14 = matrix[3];
            var m15 = matrix[4];

            var m21 = matrix[5];
            var m22 = matrix[6];
            var m23 = matrix[7];
            var m24 = matrix[8];
            var m25 = matrix[9];

            var m31 = matrix[10];
            var m32 = matrix[11];
            var m33 = matrix[12];
            var m34 = matrix[13];
            var m35 = matrix[14];

            var m41 = matrix[15];
            var m42 = matrix[16];
            var m43 = matrix[17];
            var m44 = matrix[18];
            var m45 = matrix[19];

            var index = 0,
                r = 0.0,
                g = 0.0,
                b = 0.0,
                a = 0.0,
                mr = 0.0,
                mg = 0.0,
                mb = 0.0,
                ma = 0.0,
                or = 0.0,
                og = 0.0,
                ob = 0.0;

            for (; index < l; index += 4) {
                r = data[index] / 255;
                g = data[index + 1] / 255;
                b = data[index + 2] / 255;
                a = data[index + 3] / 255;

                mr = r * m11 + g * m12 + b * m13 + a * m14 + m15;
                mg = r * m21 + g * m22 + b * m23 + a * m24 + m25;
                mb = r * m31 + g * m32 + b * m33 + a * m34 + m35;
                ma = r * m41 + g * m42 + b * m43 + a * m44 + m45;

                or = Math.max(0, mr * ma) + br * (1.0 - ma);
                og = Math.max(0, mg * ma) + bg * (1.0 - ma);
                ob = Math.max(0, mb * ma) + bb * (1.0 - ma);

                data[index] = Math.max(0.0, Math.min(1.0, or)) * 255;
                data[index + 1] = Math.max(0.0, Math.min(1.0, og)) * 255;
                data[index + 2] = Math.max(0.0, Math.min(1.0, ob)) * 255;
                // don't update alpha value
            }

            return imageData;
        }

        function resize(imageData, data) {
            var _data$mode = data.mode,
                mode = _data$mode === void 0 ? 'contain' : _data$mode,
                _data$upscale = data.upscale,
                upscale = _data$upscale === void 0 ? false : _data$upscale,
                width = data.width,
                height = data.height,
                matrix = data.matrix;

            // test if is identity matrix
            matrix = !matrix || isIdentityMatrix(matrix) ? null : matrix;

            // need at least a width or a height
            // also 0 is not a valid width or height
            if (!width && !height) {
                return filter(imageData, matrix);
            }

            // make sure all bounds are set
            if (width === null) {
                width = height;
            } else if (height === null) {
                height = width;
            }

            if (mode !== 'force') {
                var scalarWidth = width / imageData.width;
                var scalarHeight = height / imageData.height;
                var scalar = 1;

                if (mode === 'cover') {
                    scalar = Math.max(scalarWidth, scalarHeight);
                } else if (mode === 'contain') {
                    scalar = Math.min(scalarWidth, scalarHeight);
                }

                // if image is too small, exit here with original image
                if (scalar > 1 && upscale === false) {
                    return filter(imageData, matrix);
                }

                width = imageData.width * scalar;
                height = imageData.height * scalar;
            }

            var originWidth = imageData.width;
            var originHeight = imageData.height;
            var targetWidth = Math.round(width);
            var targetHeight = Math.round(height);
            var inputData = imageData.data;
            var outputData = new Uint8ClampedArray(targetWidth * targetHeight * 4);
            var ratioWidth = originWidth / targetWidth;
            var ratioHeight = originHeight / targetHeight;
            var ratioWidthHalf = Math.ceil(ratioWidth * 0.5);
            var ratioHeightHalf = Math.ceil(ratioHeight * 0.5);

            for (var j = 0; j < targetHeight; j++) {
                for (var i = 0; i < targetWidth; i++) {
                    var x2 = (i + j * targetWidth) * 4;
                    var weight = 0;
                    var weights = 0;
                    var weightsAlpha = 0;
                    var r = 0;
                    var g = 0;
                    var b = 0;
                    var a = 0;
                    var centerY = (j + 0.5) * ratioHeight;

                    for (var yy = Math.floor(j * ratioHeight); yy < (j + 1) * ratioHeight; yy++) {
                        var dy = Math.abs(centerY - (yy + 0.5)) / ratioHeightHalf;
                        var centerX = (i + 0.5) * ratioWidth;
                        var w0 = dy * dy;

                        for (var xx = Math.floor(i * ratioWidth); xx < (i + 1) * ratioWidth; xx++) {
                            var dx = Math.abs(centerX - (xx + 0.5)) / ratioWidthHalf;
                            var w = Math.sqrt(w0 + dx * dx);

                            if (w >= -1 && w <= 1) {
                                weight = 2 * w * w * w - 3 * w * w + 1;

                                if (weight > 0) {
                                    dx = 4 * (xx + yy * originWidth);

                                    var ref = inputData[dx + 3];
                                    a += weight * ref;
                                    weightsAlpha += weight;

                                    if (ref < 255) {
                                        weight = (weight * ref) / 250;
                                    }

                                    r += weight * inputData[dx];
                                    g += weight * inputData[dx + 1];
                                    b += weight * inputData[dx + 2];
                                    weights += weight;
                                }
                            }
                        }
                    }

                    outputData[x2] = r / weights;
                    outputData[x2 + 1] = g / weights;
                    outputData[x2 + 2] = b / weights;
                    outputData[x2 + 3] = a / weightsAlpha;

                    matrix && applyFilterMatrix(x2, outputData, matrix);
                }
            }

            return {
                data: outputData,
                width: targetWidth,
                height: targetHeight,
            };
        }
    };
    /* javascript-obfuscator:enable */

    var correctOrientation = function correctOrientation(view, offset) {
        // Missing 0x45786966 Marker? No Exif Header, stop here
        if (view.getUint32(offset + 4, false) !== 0x45786966) return;

        // next byte!
        offset += 4;

        // First 2bytes defines byte align of TIFF data.
        // If it is 0x4949="I I", it means "Intel" type byte align
        var intelByteAligned = view.getUint16((offset += 6), false) === 0x4949;
        offset += view.getUint32(offset + 4, intelByteAligned);

        var tags = view.getUint16(offset, intelByteAligned);
        offset += 2;

        // find Orientation tag
        for (var i = 0; i < tags; i++) {
            if (view.getUint16(offset + i * 12, intelByteAligned) === 0x0112) {
                view.setUint16(offset + i * 12 + 8, 1, intelByteAligned);
                return true;
            }
        }
        return false;
    };

    var readData = function readData(data) {
        var view = new DataView(data);

        // Every JPEG file starts from binary value '0xFFD8'
        // If it's not present, exit here
        if (view.getUint16(0) !== 0xffd8) return null;

        var offset = 2; // Start at 2 as we skipped two bytes (FFD8)
        var marker;
        var markerLength;
        var orientationCorrected = false;

        while (offset < view.byteLength) {
            marker = view.getUint16(offset, false);
            markerLength = view.getUint16(offset + 2, false) + 2;

            // Test if is APP and COM markers
            var isData = (marker >= 0xffe0 && marker <= 0xffef) || marker === 0xfffe;
            if (!isData) {
                break;
            }

            if (!orientationCorrected) {
                orientationCorrected = correctOrientation(view, offset, markerLength);
            }

            if (offset + markerLength > view.byteLength) {
                break;
            }

            offset += markerLength;
        }
        return data.slice(0, offset);
    };

    var getImageHead = function getImageHead(file) {
        return new Promise(function(resolve) {
            var reader = new FileReader();
            reader.onload = function() {
                return resolve(readData(reader.result) || null);
            };
            reader.readAsArrayBuffer(file.slice(0, 256 * 1024));
        });
    };

    var getBlobBuilder = function getBlobBuilder() {
        return (window.BlobBuilder =
            window.BlobBuilder ||
            window.WebKitBlobBuilder ||
            window.MozBlobBuilder ||
            window.MSBlobBuilder);
    };

    var createBlob = function createBlob(arrayBuffer, mimeType) {
        var BB = getBlobBuilder();

        if (BB) {
            var bb = new BB();
            bb.append(arrayBuffer);
            return bb.getBlob(mimeType);
        }

        return new Blob([arrayBuffer], {
            type: mimeType,
        });
    };

    var getUniqueId = function getUniqueId() {
        return Math.random()
            .toString(36)
            .substr(2, 9);
    };

    var createWorker = function createWorker(fn) {
        var workerBlob = new Blob(['(', fn.toString(), ')()'], { type: 'application/javascript' });
        var workerURL = URL.createObjectURL(workerBlob);
        var worker = new Worker(workerURL);

        var trips = [];

        return {
            transfer: function transfer() {}, // (message, cb) => {}
            post: function post(message, cb, transferList) {
                var id = getUniqueId();
                trips[id] = cb;

                worker.onmessage = function(e) {
                    var cb = trips[e.data.id];
                    if (!cb) return;
                    cb(e.data.message);
                    delete trips[e.data.id];
                };

                worker.postMessage(
                    {
                        id: id,
                        message: message,
                    },

                    transferList
                );
            },
            terminate: function terminate() {
                worker.terminate();
                URL.revokeObjectURL(workerURL);
            },
        };
    };

    var loadImage = function loadImage(url) {
        return new Promise(function(resolve, reject) {
            var img = new Image();
            img.onload = function() {
                resolve(img);
            };
            img.onerror = function(e) {
                reject(e);
            };
            img.src = url;
        });
    };

    var chain = function chain(funcs) {
        return funcs.reduce(function(promise, func) {
            return promise.then(function(result) {
                return func().then(Array.prototype.concat.bind(result));
            });
        }, Promise.resolve([]));
    };

    var canvasApplyMarkup = function canvasApplyMarkup(canvas, markup) {
        return new Promise(function(resolve) {
            var size = {
                width: canvas.width,
                height: canvas.height,
            };

            var ctx = canvas.getContext('2d');

            var drawers = markup.sort(sortMarkupByZIndex).map(function(item) {
                return function() {
                    return new Promise(function(resolve) {
                        var result = TYPE_DRAW_ROUTES[item[0]](ctx, size, item[1], resolve);
                        if (result) resolve();
                    });
                };
            });

            chain(drawers).then(function() {
                return resolve(canvas);
            });
        });
    };

    var applyMarkupStyles = function applyMarkupStyles(ctx, styles) {
        ctx.beginPath();
        ctx.lineCap = styles['stroke-linecap'];
        ctx.lineJoin = styles['stroke-linejoin'];
        ctx.lineWidth = styles['stroke-width'];
        if (styles['stroke-dasharray'].length) {
            ctx.setLineDash(styles['stroke-dasharray'].split(','));
        }
        ctx.fillStyle = styles['fill'];
        ctx.strokeStyle = styles['stroke'];
        ctx.globalAlpha = styles.opacity || 1;
    };

    var drawMarkupStyles = function drawMarkupStyles(ctx) {
        ctx.fill();
        ctx.stroke();
        ctx.globalAlpha = 1;
    };

    var drawRect = function drawRect(ctx, size, markup) {
        var rect = getMarkupRect(markup, size);
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);
        ctx.rect(rect.x, rect.y, rect.width, rect.height);
        drawMarkupStyles(ctx, styles);
        return true;
    };

    var drawEllipse = function drawEllipse(ctx, size, markup) {
        var rect = getMarkupRect(markup, size);
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);

        var x = rect.x,
            y = rect.y,
            w = rect.width,
            h = rect.height,
            kappa = 0.5522848,
            ox = (w / 2) * kappa,
            oy = (h / 2) * kappa,
            xe = x + w,
            ye = y + h,
            xm = x + w / 2,
            ym = y + h / 2;

        ctx.moveTo(x, ym);
        ctx.bezierCurveTo(x, ym - oy, xm - ox, y, xm, y);
        ctx.bezierCurveTo(xm + ox, y, xe, ym - oy, xe, ym);
        ctx.bezierCurveTo(xe, ym + oy, xm + ox, ye, xm, ye);
        ctx.bezierCurveTo(xm - ox, ye, x, ym + oy, x, ym);

        drawMarkupStyles(ctx, styles);
        return true;
    };

    var drawImage = function drawImage(ctx, size, markup, done) {
        var rect = getMarkupRect(markup, size);
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);

        var image = new Image();

        // if is cross origin image add cross origin attribute
        var isCrossOriginImage =
            new URL(markup.src, window.location.href).origin !== window.location.origin;
        if (isCrossOriginImage) image.crossOrigin = '';

        image.onload = function() {
            if (markup.fit === 'cover') {
                var ar = rect.width / rect.height;
                var width = ar > 1 ? image.width : image.height * ar;
                var height = ar > 1 ? image.width / ar : image.height;
                var x = image.width * 0.5 - width * 0.5;
                var y = image.height * 0.5 - height * 0.5;
                ctx.drawImage(image, x, y, width, height, rect.x, rect.y, rect.width, rect.height);
            } else if (markup.fit === 'contain') {
                var scalar = Math.min(rect.width / image.width, rect.height / image.height);
                var _width = scalar * image.width;
                var _height = scalar * image.height;
                var _x = rect.x + rect.width * 0.5 - _width * 0.5;
                var _y = rect.y + rect.height * 0.5 - _height * 0.5;
                ctx.drawImage(image, 0, 0, image.width, image.height, _x, _y, _width, _height);
            } else {
                ctx.drawImage(
                    image,
                    0,
                    0,
                    image.width,
                    image.height,
                    rect.x,
                    rect.y,
                    rect.width,
                    rect.height
                );
            }

            drawMarkupStyles(ctx, styles);
            done();
        };
        image.src = markup.src;
    };

    var drawText = function drawText(ctx, size, markup) {
        var rect = getMarkupRect(markup, size);
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);

        var fontSize = getMarkupValue(markup.fontSize, size);
        var fontFamily = markup.fontFamily || 'sans-serif';
        var fontWeight = markup.fontWeight || 'normal';
        var textAlign = markup.textAlign || 'left';

        ctx.font = ''
            .concat(fontWeight, ' ')
            .concat(fontSize, 'px ')
            .concat(fontFamily);
        ctx.textAlign = textAlign;
        ctx.fillText(markup.text, rect.x, rect.y);

        drawMarkupStyles(ctx, styles);
        return true;
    };

    var drawPath = function drawPath(ctx, size, markup) {
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);
        ctx.beginPath();

        var points = markup.points.map(function(point) {
            return {
                x: getMarkupValue(point.x, size, 1, 'width'),
                y: getMarkupValue(point.y, size, 1, 'height'),
            };
        });

        ctx.moveTo(points[0].x, points[0].y);
        var l = points.length;
        for (var i = 1; i < l; i++) {
            ctx.lineTo(points[i].x, points[i].y);
        }

        drawMarkupStyles(ctx, styles);
        return true;
    };

    var drawLine = function drawLine(ctx, size, markup) {
        var rect = getMarkupRect(markup, size);
        var styles = getMarkupStyles(markup, size);
        applyMarkupStyles(ctx, styles);

        ctx.beginPath();

        var origin = {
            x: rect.x,
            y: rect.y,
        };

        var target = {
            x: rect.x + rect.width,
            y: rect.y + rect.height,
        };

        ctx.moveTo(origin.x, origin.y);
        ctx.lineTo(target.x, target.y);

        var v = vectorNormalize({
            x: target.x - origin.x,
            y: target.y - origin.y,
        });

        var l = 0.04 * Math.min(size.width, size.height);

        if (markup.lineDecoration.indexOf('arrow-begin') !== -1) {
            var arrowBeginRotationPoint = vectorMultiply(v, l);
            var arrowBeginCenter = vectorAdd(origin, arrowBeginRotationPoint);
            var arrowBeginA = vectorRotate(origin, 2, arrowBeginCenter);
            var arrowBeginB = vectorRotate(origin, -2, arrowBeginCenter);

            ctx.moveTo(arrowBeginA.x, arrowBeginA.y);
            ctx.lineTo(origin.x, origin.y);
            ctx.lineTo(arrowBeginB.x, arrowBeginB.y);
        }
        if (markup.lineDecoration.indexOf('arrow-end') !== -1) {
            var arrowEndRotationPoint = vectorMultiply(v, -l);
            var arrowEndCenter = vectorAdd(target, arrowEndRotationPoint);
            var arrowEndA = vectorRotate(target, 2, arrowEndCenter);
            var arrowEndB = vectorRotate(target, -2, arrowEndCenter);

            ctx.moveTo(arrowEndA.x, arrowEndA.y);
            ctx.lineTo(target.x, target.y);
            ctx.lineTo(arrowEndB.x, arrowEndB.y);
        }

        drawMarkupStyles(ctx, styles);
        return true;
    };

    var TYPE_DRAW_ROUTES = {
        rect: drawRect,
        ellipse: drawEllipse,
        image: drawImage,
        text: drawText,
        line: drawLine,
        path: drawPath,
    };

    var imageDataToCanvas = function imageDataToCanvas(imageData) {
        var image = document.createElement('canvas');
        image.width = imageData.width;
        image.height = imageData.height;
        var ctx = image.getContext('2d');
        ctx.putImageData(imageData, 0, 0);
        return image;
    };

    var transformImage = function transformImage(file, instructions) {
        var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        return new Promise(function(resolve, reject) {
            // if the file is not an image we do not have any business transforming it
            if (!file || !isImage$1(file))
                return reject({ status: 'not an image file', file: file });

            // get separate options for easier use
            var stripImageHead = options.stripImageHead,
                beforeCreateBlob = options.beforeCreateBlob,
                afterCreateBlob = options.afterCreateBlob,
                canvasMemoryLimit = options.canvasMemoryLimit;

            // get crop
            var crop = instructions.crop,
                size = instructions.size,
                filter = instructions.filter,
                markup = instructions.markup,
                output = instructions.output;

            // get exif orientation
            var orientation =
                instructions.image && instructions.image.orientation
                    ? Math.max(1, Math.min(8, instructions.image.orientation))
                    : null;

            // compression quality 0 => 100
            var qualityAsPercentage = output && output.quality;
            var quality = qualityAsPercentage === null ? null : qualityAsPercentage / 100;

            // output format
            var type = (output && output.type) || null;

            // background color
            var background = (output && output.background) || null;

            // get transforms
            var transforms = [];

            // add resize transforms if set
            if (size && (typeof size.width === 'number' || typeof size.height === 'number')) {
                transforms.push({ type: 'resize', data: size });
            }

            // add filters
            if (filter && filter.length === 20) {
                transforms.push({ type: 'filter', data: filter });
            }

            // resolves with supplied blob
            var resolveWithBlob = function resolveWithBlob(blob) {
                var promisedBlob = afterCreateBlob ? afterCreateBlob(blob) : blob;
                Promise.resolve(promisedBlob).then(resolve);
            };

            // done
            var toBlob = function toBlob(imageData, options) {
                var canvas = imageDataToCanvas(imageData);
                var promisedCanvas = markup.length ? canvasApplyMarkup(canvas, markup) : canvas;
                Promise.resolve(promisedCanvas).then(function(canvas) {
                    canvasToBlob(canvas, options, beforeCreateBlob)
                        .then(function(blob) {
                            // force release of canvas memory
                            canvasRelease(canvas);

                            // remove image head (default)
                            if (stripImageHead) return resolveWithBlob(blob);

                            // try to copy image head from original file to generated blob
                            getImageHead(file).then(function(imageHead) {
                                // re-inject image head in case of JPEG, as the image head is removed by canvas export
                                if (imageHead !== null) {
                                    blob = new Blob([imageHead, blob.slice(20)], {
                                        type: blob.type,
                                    });
                                }

                                // done!
                                resolveWithBlob(blob);
                            });
                        })
                        .catch(reject);
                });
            };

            // if this is an svg and we want it to stay an svg
            if (/svg/.test(file.type) && type === null) {
                return cropSVG(file, crop, markup, { background: background }).then(function(text) {
                    resolve(createBlob(text, 'image/svg+xml'));
                });
            }

            // get file url
            var url = URL.createObjectURL(file);

            // turn the file into an image
            loadImage(url)
                .then(function(image) {
                    // url is no longer needed
                    URL.revokeObjectURL(url);

                    // draw to canvas and start transform chain
                    var imageData = imageToImageData(image, orientation, crop, {
                        canvasMemoryLimit: canvasMemoryLimit,
                        background: background,
                    });

                    // determine the format of the blob that we will output
                    var outputFormat = {
                        quality: quality,
                        type: type || file.type,
                    };

                    // no transforms necessary, we done!
                    if (!transforms.length) {
                        return toBlob(imageData, outputFormat);
                    }

                    // send to the transform worker to transform the blob on a separate thread
                    var worker = createWorker(TransformWorker);
                    worker.post(
                        {
                            transforms: transforms,
                            imageData: imageData,
                        },

                        function(response) {
                            // finish up
                            toBlob(objectToImageData(response), outputFormat);

                            // stop worker
                            worker.terminate();
                        },
                        [imageData.data.buffer]
                    );
                })
                .catch(reject);
        });
    };

    function _typeof(obj) {
        if (typeof Symbol === 'function' && typeof Symbol.iterator === 'symbol') {
            _typeof = function(obj) {
                return typeof obj;
            };
        } else {
            _typeof = function(obj) {
                return obj &&
                    typeof Symbol === 'function' &&
                    obj.constructor === Symbol &&
                    obj !== Symbol.prototype
                    ? 'symbol'
                    : typeof obj;
            };
        }

        return _typeof(obj);
    }

    var REACT_ELEMENT_TYPE;

    function _jsx(type, props, key, children) {
        if (!REACT_ELEMENT_TYPE) {
            REACT_ELEMENT_TYPE =
                (typeof Symbol === 'function' && Symbol.for && Symbol.for('react.element')) ||
                0xeac7;
        }

        var defaultProps = type && type.defaultProps;
        var childrenLength = arguments.length - 3;

        if (!props && childrenLength !== 0) {
            props = {
                children: void 0,
            };
        }

        if (props && defaultProps) {
            for (var propName in defaultProps) {
                if (props[propName] === void 0) {
                    props[propName] = defaultProps[propName];
                }
            }
        } else if (!props) {
            props = defaultProps || {};
        }

        if (childrenLength === 1) {
            props.children = children;
        } else if (childrenLength > 1) {
            var childArray = new Array(childrenLength);

            for (var i = 0; i < childrenLength; i++) {
                childArray[i] = arguments[i + 3];
            }

            props.children = childArray;
        }

        return {
            $$typeof: REACT_ELEMENT_TYPE,
            type: type,
            key: key === undefined ? null : '' + key,
            ref: null,
            props: props,
            _owner: null,
        };
    }

    function _asyncIterator(iterable) {
        var method;

        if (typeof Symbol === 'function') {
            if (Symbol.asyncIterator) {
                method = iterable[Symbol.asyncIterator];
                if (method != null) return method.call(iterable);
            }

            if (Symbol.iterator) {
                method = iterable[Symbol.iterator];
                if (method != null) return method.call(iterable);
            }
        }

        throw new TypeError('Object is not async iterable');
    }

    function _AwaitValue(value) {
        this.wrapped = value;
    }

    function _AsyncGenerator(gen) {
        var front, back;

        function send(key, arg) {
            return new Promise(function(resolve, reject) {
                var request = {
                    key: key,
                    arg: arg,
                    resolve: resolve,
                    reject: reject,
                    next: null,
                };

                if (back) {
                    back = back.next = request;
                } else {
                    front = back = request;
                    resume(key, arg);
                }
            });
        }

        function resume(key, arg) {
            try {
                var result = gen[key](arg);
                var value = result.value;
                var wrappedAwait = value instanceof _AwaitValue;
                Promise.resolve(wrappedAwait ? value.wrapped : value).then(
                    function(arg) {
                        if (wrappedAwait) {
                            resume('next', arg);
                            return;
                        }

                        settle(result.done ? 'return' : 'normal', arg);
                    },
                    function(err) {
                        resume('throw', err);
                    }
                );
            } catch (err) {
                settle('throw', err);
            }
        }

        function settle(type, value) {
            switch (type) {
                case 'return':
                    front.resolve({
                        value: value,
                        done: true,
                    });
                    break;

                case 'throw':
                    front.reject(value);
                    break;

                default:
                    front.resolve({
                        value: value,
                        done: false,
                    });
                    break;
            }

            front = front.next;

            if (front) {
                resume(front.key, front.arg);
            } else {
                back = null;
            }
        }

        this._invoke = send;

        if (typeof gen.return !== 'function') {
            this.return = undefined;
        }
    }

    if (typeof Symbol === 'function' && Symbol.asyncIterator) {
        _AsyncGenerator.prototype[Symbol.asyncIterator] = function() {
            return this;
        };
    }

    _AsyncGenerator.prototype.next = function(arg) {
        return this._invoke('next', arg);
    };

    _AsyncGenerator.prototype.throw = function(arg) {
        return this._invoke('throw', arg);
    };

    _AsyncGenerator.prototype.return = function(arg) {
        return this._invoke('return', arg);
    };

    function _wrapAsyncGenerator(fn) {
        return function() {
            return new _AsyncGenerator(fn.apply(this, arguments));
        };
    }

    function _awaitAsyncGenerator(value) {
        return new _AwaitValue(value);
    }

    function _asyncGeneratorDelegate(inner, awaitWrap) {
        var iter = {},
            waiting = false;

        function pump(key, value) {
            waiting = true;
            value = new Promise(function(resolve) {
                resolve(inner[key](value));
            });
            return {
                done: false,
                value: awaitWrap(value),
            };
        }

        if (typeof Symbol === 'function' && Symbol.iterator) {
            iter[Symbol.iterator] = function() {
                return this;
            };
        }

        iter.next = function(value) {
            if (waiting) {
                waiting = false;
                return value;
            }

            return pump('next', value);
        };

        if (typeof inner.throw === 'function') {
            iter.throw = function(value) {
                if (waiting) {
                    waiting = false;
                    throw value;
                }

                return pump('throw', value);
            };
        }

        if (typeof inner.return === 'function') {
            iter.return = function(value) {
                return pump('return', value);
            };
        }

        return iter;
    }

    function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
        try {
            var info = gen[key](arg);
            var value = info.value;
        } catch (error) {
            reject(error);
            return;
        }

        if (info.done) {
            resolve(value);
        } else {
            Promise.resolve(value).then(_next, _throw);
        }
    }

    function _asyncToGenerator(fn) {
        return function() {
            var self = this,
                args = arguments;
            return new Promise(function(resolve, reject) {
                var gen = fn.apply(self, args);

                function _next(value) {
                    asyncGeneratorStep(gen, resolve, reject, _next, _throw, 'next', value);
                }

                function _throw(err) {
                    asyncGeneratorStep(gen, resolve, reject, _next, _throw, 'throw', err);
                }

                _next(undefined);
            });
        };
    }

    function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
            throw new TypeError('Cannot call a class as a function');
        }
    }

    function _defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }

    function _createClass(Constructor, protoProps, staticProps) {
        if (protoProps) _defineProperties(Constructor.prototype, protoProps);
        if (staticProps) _defineProperties(Constructor, staticProps);
        return Constructor;
    }

    function _defineEnumerableProperties(obj, descs) {
        for (var key in descs) {
            var desc = descs[key];
            desc.configurable = desc.enumerable = true;
            if ('value' in desc) desc.writable = true;
            Object.defineProperty(obj, key, desc);
        }

        if (Object.getOwnPropertySymbols) {
            var objectSymbols = Object.getOwnPropertySymbols(descs);

            for (var i = 0; i < objectSymbols.length; i++) {
                var sym = objectSymbols[i];
                var desc = descs[sym];
                desc.configurable = desc.enumerable = true;
                if ('value' in desc) desc.writable = true;
                Object.defineProperty(obj, sym, desc);
            }
        }

        return obj;
    }

    function _defaults(obj, defaults) {
        var keys = Object.getOwnPropertyNames(defaults);

        for (var i = 0; i < keys.length; i++) {
            var key = keys[i];
            var value = Object.getOwnPropertyDescriptor(defaults, key);

            if (value && value.configurable && obj[key] === undefined) {
                Object.defineProperty(obj, key, value);
            }
        }

        return obj;
    }

    function _defineProperty(obj, key, value) {
        if (key in obj) {
            Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
            });
        } else {
            obj[key] = value;
        }

        return obj;
    }

    function _extends() {
        _extends =
            Object.assign ||
            function(target) {
                for (var i = 1; i < arguments.length; i++) {
                    var source = arguments[i];

                    for (var key in source) {
                        if (Object.prototype.hasOwnProperty.call(source, key)) {
                            target[key] = source[key];
                        }
                    }
                }

                return target;
            };

        return _extends.apply(this, arguments);
    }

    function _objectSpread(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i] != null ? arguments[i] : {};
            var ownKeys = Object.keys(source);

            if (typeof Object.getOwnPropertySymbols === 'function') {
                ownKeys = ownKeys.concat(
                    Object.getOwnPropertySymbols(source).filter(function(sym) {
                        return Object.getOwnPropertyDescriptor(source, sym).enumerable;
                    })
                );
            }

            ownKeys.forEach(function(key) {
                _defineProperty(target, key, source[key]);
            });
        }

        return target;
    }

    function _inherits(subClass, superClass) {
        if (typeof superClass !== 'function' && superClass !== null) {
            throw new TypeError('Super expression must either be null or a function');
        }

        subClass.prototype = Object.create(superClass && superClass.prototype, {
            constructor: {
                value: subClass,
                writable: true,
                configurable: true,
            },
        });
        if (superClass) _setPrototypeOf(subClass, superClass);
    }

    function _inheritsLoose(subClass, superClass) {
        subClass.prototype = Object.create(superClass.prototype);
        subClass.prototype.constructor = subClass;
        subClass.__proto__ = superClass;
    }

    function _getPrototypeOf(o) {
        _getPrototypeOf = Object.setPrototypeOf
            ? Object.getPrototypeOf
            : function _getPrototypeOf(o) {
                  return o.__proto__ || Object.getPrototypeOf(o);
              };
        return _getPrototypeOf(o);
    }

    function _setPrototypeOf(o, p) {
        _setPrototypeOf =
            Object.setPrototypeOf ||
            function _setPrototypeOf(o, p) {
                o.__proto__ = p;
                return o;
            };

        return _setPrototypeOf(o, p);
    }

    function isNativeReflectConstruct() {
        if (typeof Reflect === 'undefined' || !Reflect.construct) return false;
        if (Reflect.construct.sham) return false;
        if (typeof Proxy === 'function') return true;

        try {
            Date.prototype.toString.call(Reflect.construct(Date, [], function() {}));
            return true;
        } catch (e) {
            return false;
        }
    }

    function _construct(Parent, args, Class) {
        if (isNativeReflectConstruct()) {
            _construct = Reflect.construct;
        } else {
            _construct = function _construct(Parent, args, Class) {
                var a = [null];
                a.push.apply(a, args);
                var Constructor = Function.bind.apply(Parent, a);
                var instance = new Constructor();
                if (Class) _setPrototypeOf(instance, Class.prototype);
                return instance;
            };
        }

        return _construct.apply(null, arguments);
    }

    function _isNativeFunction(fn) {
        return Function.toString.call(fn).indexOf('[native code]') !== -1;
    }

    function _wrapNativeSuper(Class) {
        var _cache = typeof Map === 'function' ? new Map() : undefined;

        _wrapNativeSuper = function _wrapNativeSuper(Class) {
            if (Class === null || !_isNativeFunction(Class)) return Class;

            if (typeof Class !== 'function') {
                throw new TypeError('Super expression must either be null or a function');
            }

            if (typeof _cache !== 'undefined') {
                if (_cache.has(Class)) return _cache.get(Class);

                _cache.set(Class, Wrapper);
            }

            function Wrapper() {
                return _construct(Class, arguments, _getPrototypeOf(this).constructor);
            }

            Wrapper.prototype = Object.create(Class.prototype, {
                constructor: {
                    value: Wrapper,
                    enumerable: false,
                    writable: true,
                    configurable: true,
                },
            });
            return _setPrototypeOf(Wrapper, Class);
        };

        return _wrapNativeSuper(Class);
    }

    function _instanceof(left, right) {
        if (right != null && typeof Symbol !== 'undefined' && right[Symbol.hasInstance]) {
            return right[Symbol.hasInstance](left);
        } else {
            return left instanceof right;
        }
    }

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule
            ? obj
            : {
                  default: obj,
              };
    }

    function _interopRequireWildcard(obj) {
        if (obj && obj.__esModule) {
            return obj;
        } else {
            var newObj = {};

            if (obj != null) {
                for (var key in obj) {
                    if (Object.prototype.hasOwnProperty.call(obj, key)) {
                        var desc =
                            Object.defineProperty && Object.getOwnPropertyDescriptor
                                ? Object.getOwnPropertyDescriptor(obj, key)
                                : {};

                        if (desc.get || desc.set) {
                            Object.defineProperty(newObj, key, desc);
                        } else {
                            newObj[key] = obj[key];
                        }
                    }
                }
            }

            newObj.default = obj;
            return newObj;
        }
    }

    function _newArrowCheck(innerThis, boundThis) {
        if (innerThis !== boundThis) {
            throw new TypeError('Cannot instantiate an arrow function');
        }
    }

    function _objectDestructuringEmpty(obj) {
        if (obj == null) throw new TypeError('Cannot destructure undefined');
    }

    function _objectWithoutPropertiesLoose(source, excluded) {
        if (source == null) return {};
        var target = {};
        var sourceKeys = Object.keys(source);
        var key, i;

        for (i = 0; i < sourceKeys.length; i++) {
            key = sourceKeys[i];
            if (excluded.indexOf(key) >= 0) continue;
            target[key] = source[key];
        }

        return target;
    }

    function _objectWithoutProperties(source, excluded) {
        if (source == null) return {};

        var target = _objectWithoutPropertiesLoose(source, excluded);

        var key, i;

        if (Object.getOwnPropertySymbols) {
            var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

            for (i = 0; i < sourceSymbolKeys.length; i++) {
                key = sourceSymbolKeys[i];
                if (excluded.indexOf(key) >= 0) continue;
                if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
                target[key] = source[key];
            }
        }

        return target;
    }

    function _assertThisInitialized(self) {
        if (self === void 0) {
            throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        }

        return self;
    }

    function _possibleConstructorReturn(self, call) {
        if (call && (typeof call === 'object' || typeof call === 'function')) {
            return call;
        }

        return _assertThisInitialized(self);
    }

    function _superPropBase(object, property) {
        while (!Object.prototype.hasOwnProperty.call(object, property)) {
            object = _getPrototypeOf(object);
            if (object === null) break;
        }

        return object;
    }

    function _get(target, property, receiver) {
        if (typeof Reflect !== 'undefined' && Reflect.get) {
            _get = Reflect.get;
        } else {
            _get = function _get(target, property, receiver) {
                var base = _superPropBase(target, property);

                if (!base) return;
                var desc = Object.getOwnPropertyDescriptor(base, property);

                if (desc.get) {
                    return desc.get.call(receiver);
                }

                return desc.value;
            };
        }

        return _get(target, property, receiver || target);
    }

    function set(target, property, value, receiver) {
        if (typeof Reflect !== 'undefined' && Reflect.set) {
            set = Reflect.set;
        } else {
            set = function set(target, property, value, receiver) {
                var base = _superPropBase(target, property);

                var desc;

                if (base) {
                    desc = Object.getOwnPropertyDescriptor(base, property);

                    if (desc.set) {
                        desc.set.call(receiver, value);
                        return true;
                    } else if (!desc.writable) {
                        return false;
                    }
                }

                desc = Object.getOwnPropertyDescriptor(receiver, property);

                if (desc) {
                    if (!desc.writable) {
                        return false;
                    }

                    desc.value = value;
                    Object.defineProperty(receiver, property, desc);
                } else {
                    _defineProperty(receiver, property, value);
                }

                return true;
            };
        }

        return set(target, property, value, receiver);
    }

    function _set(target, property, value, receiver, isStrict) {
        var s = set(target, property, value, receiver || target);

        if (!s && isStrict) {
            throw new Error('failed to set property');
        }

        return value;
    }

    function _taggedTemplateLiteral(strings, raw) {
        if (!raw) {
            raw = strings.slice(0);
        }

        return Object.freeze(
            Object.defineProperties(strings, {
                raw: {
                    value: Object.freeze(raw),
                },
            })
        );
    }

    function _taggedTemplateLiteralLoose(strings, raw) {
        if (!raw) {
            raw = strings.slice(0);
        }

        strings.raw = raw;
        return strings;
    }

    function _temporalRef(val, name) {
        if (val === _temporalUndefined) {
            throw new ReferenceError(name + ' is not defined - temporal dead zone');
        } else {
            return val;
        }
    }

    function _readOnlyError(name) {
        throw new Error('"' + name + '" is read-only');
    }

    function _classNameTDZError(name) {
        throw new Error('Class "' + name + '" cannot be referenced in computed property keys.');
    }

    var _temporalUndefined = {};

    function _slicedToArray(arr, i) {
        return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest();
    }

    function _slicedToArrayLoose(arr, i) {
        return _arrayWithHoles(arr) || _iterableToArrayLimitLoose(arr, i) || _nonIterableRest();
    }

    function _toArray(arr) {
        return _arrayWithHoles(arr) || _iterableToArray(arr) || _nonIterableRest();
    }

    function _toConsumableArray(arr) {
        return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
    }

    function _arrayWithoutHoles(arr) {
        if (Array.isArray(arr)) {
            for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) arr2[i] = arr[i];

            return arr2;
        }
    }

    function _arrayWithHoles(arr) {
        if (Array.isArray(arr)) return arr;
    }

    function _iterableToArray(iter) {
        if (
            Symbol.iterator in Object(iter) ||
            Object.prototype.toString.call(iter) === '[object Arguments]'
        )
            return Array.from(iter);
    }

    function _iterableToArrayLimit(arr, i) {
        var _arr = [];
        var _n = true;
        var _d = false;
        var _e = undefined;

        try {
            for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
                _arr.push(_s.value);

                if (i && _arr.length === i) break;
            }
        } catch (err) {
            _d = true;
            _e = err;
        } finally {
            try {
                if (!_n && _i['return'] != null) _i['return']();
            } finally {
                if (_d) throw _e;
            }
        }

        return _arr;
    }

    function _iterableToArrayLimitLoose(arr, i) {
        var _arr = [];

        for (var _iterator = arr[Symbol.iterator](), _step; !(_step = _iterator.next()).done; ) {
            _arr.push(_step.value);

            if (i && _arr.length === i) break;
        }

        return _arr;
    }

    function _nonIterableSpread() {
        throw new TypeError('Invalid attempt to spread non-iterable instance');
    }

    function _nonIterableRest() {
        throw new TypeError('Invalid attempt to destructure non-iterable instance');
    }

    function _skipFirstGeneratorNext(fn) {
        return function() {
            var it = fn.apply(this, arguments);
            it.next();
            return it;
        };
    }

    function _toPrimitive(input, hint) {
        if (typeof input !== 'object' || input === null) return input;
        var prim = input[Symbol.toPrimitive];

        if (prim !== undefined) {
            var res = prim.call(input, hint || 'default');
            if (typeof res !== 'object') return res;
            throw new TypeError('@@toPrimitive must return a primitive value.');
        }

        return (hint === 'string' ? String : Number)(input);
    }

    function _toPropertyKey(arg) {
        var key = _toPrimitive(arg, 'string');

        return typeof key === 'symbol' ? key : String(key);
    }

    function _initializerWarningHelper(descriptor, context) {
        throw new Error(
            'Decorating class property failed. Please ensure that ' +
                'proposal-class-properties is enabled and set to use loose mode. ' +
                'To use proposal-class-properties in spec mode with decorators, wait for ' +
                'the next major version of decorators in stage 2.'
        );
    }

    function _initializerDefineProperty(target, property, descriptor, context) {
        if (!descriptor) return;
        Object.defineProperty(target, property, {
            enumerable: descriptor.enumerable,
            configurable: descriptor.configurable,
            writable: descriptor.writable,
            value: descriptor.initializer ? descriptor.initializer.call(context) : void 0,
        });
    }

    function _applyDecoratedDescriptor(target, property, decorators, descriptor, context) {
        var desc = {};
        Object.keys(descriptor).forEach(function(key) {
            desc[key] = descriptor[key];
        });
        desc.enumerable = !!desc.enumerable;
        desc.configurable = !!desc.configurable;

        if ('value' in desc || desc.initializer) {
            desc.writable = true;
        }

        desc = decorators
            .slice()
            .reverse()
            .reduce(function(desc, decorator) {
                return decorator(target, property, desc) || desc;
            }, desc);

        if (context && desc.initializer !== void 0) {
            desc.value = desc.initializer ? desc.initializer.call(context) : void 0;
            desc.initializer = undefined;
        }

        if (desc.initializer === void 0) {
            Object.defineProperty(target, property, desc);
            desc = null;
        }

        return desc;
    }

    var id = 0;

    function _classPrivateFieldLooseKey(name) {
        return '__private_' + id++ + '_' + name;
    }

    function _classPrivateFieldLooseBase(receiver, privateKey) {
        if (!Object.prototype.hasOwnProperty.call(receiver, privateKey)) {
            throw new TypeError('attempted to use private field on non-instance');
        }

        return receiver;
    }

    function _classPrivateFieldGet(receiver, privateMap) {
        if (!privateMap.has(receiver)) {
            throw new TypeError('attempted to get private field on non-instance');
        }

        var descriptor = privateMap.get(receiver);

        if (descriptor.get) {
            return descriptor.get.call(receiver);
        }

        return descriptor.value;
    }

    function _classPrivateFieldSet(receiver, privateMap, value) {
        if (!privateMap.has(receiver)) {
            throw new TypeError('attempted to set private field on non-instance');
        }

        var descriptor = privateMap.get(receiver);

        if (descriptor.set) {
            descriptor.set.call(receiver, value);
        } else {
            if (!descriptor.writable) {
                throw new TypeError('attempted to set read only private field');
            }

            descriptor.value = value;
        }

        return value;
    }

    function _classStaticPrivateFieldSpecGet(receiver, classConstructor, descriptor) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        return descriptor.value;
    }

    function _classStaticPrivateFieldSpecSet(receiver, classConstructor, descriptor, value) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        if (!descriptor.writable) {
            throw new TypeError('attempted to set read only private field');
        }

        descriptor.value = value;
        return value;
    }

    function _classStaticPrivateMethodGet(receiver, classConstructor, method) {
        if (receiver !== classConstructor) {
            throw new TypeError('Private static access of wrong provenance');
        }

        return method;
    }

    function _classStaticPrivateMethodSet() {
        throw new TypeError('attempted to set read only static private field');
    }

    function _decorate(decorators, factory, superClass, mixins) {
        var api = _getDecoratorsApi();

        if (mixins) {
            for (var i = 0; i < mixins.length; i++) {
                api = mixins[i](api);
            }
        }

        var r = factory(function initialize(O) {
            api.initializeInstanceElements(O, decorated.elements);
        }, superClass);
        var decorated = api.decorateClass(
            _coalesceClassElements(r.d.map(_createElementDescriptor)),
            decorators
        );
        api.initializeClassElements(r.F, decorated.elements);
        return api.runClassFinishers(r.F, decorated.finishers);
    }

    function _getDecoratorsApi() {
        _getDecoratorsApi = function() {
            return api;
        };

        var api = {
            elementsDefinitionOrder: [['method'], ['field']],
            initializeInstanceElements: function(O, elements) {
                ['method', 'field'].forEach(function(kind) {
                    elements.forEach(function(element) {
                        if (element.kind === kind && element.placement === 'own') {
                            this.defineClassElement(O, element);
                        }
                    }, this);
                }, this);
            },
            initializeClassElements: function(F, elements) {
                var proto = F.prototype;
                ['method', 'field'].forEach(function(kind) {
                    elements.forEach(function(element) {
                        var placement = element.placement;

                        if (
                            element.kind === kind &&
                            (placement === 'static' || placement === 'prototype')
                        ) {
                            var receiver = placement === 'static' ? F : proto;
                            this.defineClassElement(receiver, element);
                        }
                    }, this);
                }, this);
            },
            defineClassElement: function(receiver, element) {
                var descriptor = element.descriptor;

                if (element.kind === 'field') {
                    var initializer = element.initializer;
                    descriptor = {
                        enumerable: descriptor.enumerable,
                        writable: descriptor.writable,
                        configurable: descriptor.configurable,
                        value: initializer === void 0 ? void 0 : initializer.call(receiver),
                    };
                }

                Object.defineProperty(receiver, element.key, descriptor);
            },
            decorateClass: function(elements, decorators) {
                var newElements = [];
                var finishers = [];
                var placements = {
                    static: [],
                    prototype: [],
                    own: [],
                };
                elements.forEach(function(element) {
                    this.addElementPlacement(element, placements);
                }, this);
                elements.forEach(function(element) {
                    if (!_hasDecorators(element)) return newElements.push(element);
                    var elementFinishersExtras = this.decorateElement(element, placements);
                    newElements.push(elementFinishersExtras.element);
                    newElements.push.apply(newElements, elementFinishersExtras.extras);
                    finishers.push.apply(finishers, elementFinishersExtras.finishers);
                }, this);

                if (!decorators) {
                    return {
                        elements: newElements,
                        finishers: finishers,
                    };
                }

                var result = this.decorateConstructor(newElements, decorators);
                finishers.push.apply(finishers, result.finishers);
                result.finishers = finishers;
                return result;
            },
            addElementPlacement: function(element, placements, silent) {
                var keys = placements[element.placement];

                if (!silent && keys.indexOf(element.key) !== -1) {
                    throw new TypeError('Duplicated element (' + element.key + ')');
                }

                keys.push(element.key);
            },
            decorateElement: function(element, placements) {
                var extras = [];
                var finishers = [];

                for (var decorators = element.decorators, i = decorators.length - 1; i >= 0; i--) {
                    var keys = placements[element.placement];
                    keys.splice(keys.indexOf(element.key), 1);
                    var elementObject = this.fromElementDescriptor(element);
                    var elementFinisherExtras = this.toElementFinisherExtras(
                        (0, decorators[i])(elementObject) || elementObject
                    );
                    element = elementFinisherExtras.element;
                    this.addElementPlacement(element, placements);

                    if (elementFinisherExtras.finisher) {
                        finishers.push(elementFinisherExtras.finisher);
                    }

                    var newExtras = elementFinisherExtras.extras;

                    if (newExtras) {
                        for (var j = 0; j < newExtras.length; j++) {
                            this.addElementPlacement(newExtras[j], placements);
                        }

                        extras.push.apply(extras, newExtras);
                    }
                }

                return {
                    element: element,
                    finishers: finishers,
                    extras: extras,
                };
            },
            decorateConstructor: function(elements, decorators) {
                var finishers = [];

                for (var i = decorators.length - 1; i >= 0; i--) {
                    var obj = this.fromClassDescriptor(elements);
                    var elementsAndFinisher = this.toClassDescriptor(
                        (0, decorators[i])(obj) || obj
                    );

                    if (elementsAndFinisher.finisher !== undefined) {
                        finishers.push(elementsAndFinisher.finisher);
                    }

                    if (elementsAndFinisher.elements !== undefined) {
                        elements = elementsAndFinisher.elements;

                        for (var j = 0; j < elements.length - 1; j++) {
                            for (var k = j + 1; k < elements.length; k++) {
                                if (
                                    elements[j].key === elements[k].key &&
                                    elements[j].placement === elements[k].placement
                                ) {
                                    throw new TypeError(
                                        'Duplicated element (' + elements[j].key + ')'
                                    );
                                }
                            }
                        }
                    }
                }

                return {
                    elements: elements,
                    finishers: finishers,
                };
            },
            fromElementDescriptor: function(element) {
                var obj = {
                    kind: element.kind,
                    key: element.key,
                    placement: element.placement,
                    descriptor: element.descriptor,
                };
                var desc = {
                    value: 'Descriptor',
                    configurable: true,
                };
                Object.defineProperty(obj, Symbol.toStringTag, desc);
                if (element.kind === 'field') obj.initializer = element.initializer;
                return obj;
            },
            toElementDescriptors: function(elementObjects) {
                if (elementObjects === undefined) return;
                return _toArray(elementObjects).map(function(elementObject) {
                    var element = this.toElementDescriptor(elementObject);
                    this.disallowProperty(elementObject, 'finisher', 'An element descriptor');
                    this.disallowProperty(elementObject, 'extras', 'An element descriptor');
                    return element;
                }, this);
            },
            toElementDescriptor: function(elementObject) {
                var kind = String(elementObject.kind);

                if (kind !== 'method' && kind !== 'field') {
                    throw new TypeError(
                        'An element descriptor\'s .kind property must be either "method" or' +
                            ' "field", but a decorator created an element descriptor with' +
                            ' .kind "' +
                            kind +
                            '"'
                    );
                }

                var key = _toPropertyKey(elementObject.key);

                var placement = String(elementObject.placement);

                if (placement !== 'static' && placement !== 'prototype' && placement !== 'own') {
                    throw new TypeError(
                        'An element descriptor\'s .placement property must be one of "static",' +
                            ' "prototype" or "own", but a decorator created an element descriptor' +
                            ' with .placement "' +
                            placement +
                            '"'
                    );
                }

                var descriptor = elementObject.descriptor;
                this.disallowProperty(elementObject, 'elements', 'An element descriptor');
                var element = {
                    kind: kind,
                    key: key,
                    placement: placement,
                    descriptor: Object.assign({}, descriptor),
                };

                if (kind !== 'field') {
                    this.disallowProperty(elementObject, 'initializer', 'A method descriptor');
                } else {
                    this.disallowProperty(
                        descriptor,
                        'get',
                        'The property descriptor of a field descriptor'
                    );
                    this.disallowProperty(
                        descriptor,
                        'set',
                        'The property descriptor of a field descriptor'
                    );
                    this.disallowProperty(
                        descriptor,
                        'value',
                        'The property descriptor of a field descriptor'
                    );
                    element.initializer = elementObject.initializer;
                }

                return element;
            },
            toElementFinisherExtras: function(elementObject) {
                var element = this.toElementDescriptor(elementObject);

                var finisher = _optionalCallableProperty(elementObject, 'finisher');

                var extras = this.toElementDescriptors(elementObject.extras);
                return {
                    element: element,
                    finisher: finisher,
                    extras: extras,
                };
            },
            fromClassDescriptor: function(elements) {
                var obj = {
                    kind: 'class',
                    elements: elements.map(this.fromElementDescriptor, this),
                };
                var desc = {
                    value: 'Descriptor',
                    configurable: true,
                };
                Object.defineProperty(obj, Symbol.toStringTag, desc);
                return obj;
            },
            toClassDescriptor: function(obj) {
                var kind = String(obj.kind);

                if (kind !== 'class') {
                    throw new TypeError(
                        'A class descriptor\'s .kind property must be "class", but a decorator' +
                            ' created a class descriptor with .kind "' +
                            kind +
                            '"'
                    );
                }

                this.disallowProperty(obj, 'key', 'A class descriptor');
                this.disallowProperty(obj, 'placement', 'A class descriptor');
                this.disallowProperty(obj, 'descriptor', 'A class descriptor');
                this.disallowProperty(obj, 'initializer', 'A class descriptor');
                this.disallowProperty(obj, 'extras', 'A class descriptor');

                var finisher = _optionalCallableProperty(obj, 'finisher');

                var elements = this.toElementDescriptors(obj.elements);
                return {
                    elements: elements,
                    finisher: finisher,
                };
            },
            runClassFinishers: function(constructor, finishers) {
                for (var i = 0; i < finishers.length; i++) {
                    var newConstructor = (0, finishers[i])(constructor);

                    if (newConstructor !== undefined) {
                        if (typeof newConstructor !== 'function') {
                            throw new TypeError('Finishers must return a constructor.');
                        }

                        constructor = newConstructor;
                    }
                }

                return constructor;
            },
            disallowProperty: function(obj, name, objectType) {
                if (obj[name] !== undefined) {
                    throw new TypeError(objectType + " can't have a ." + name + ' property.');
                }
            },
        };
        return api;
    }

    function _createElementDescriptor(def) {
        var key = _toPropertyKey(def.key);

        var descriptor;

        if (def.kind === 'method') {
            descriptor = {
                value: def.value,
                writable: true,
                configurable: true,
                enumerable: false,
            };
        } else if (def.kind === 'get') {
            descriptor = {
                get: def.value,
                configurable: true,
                enumerable: false,
            };
        } else if (def.kind === 'set') {
            descriptor = {
                set: def.value,
                configurable: true,
                enumerable: false,
            };
        } else if (def.kind === 'field') {
            descriptor = {
                configurable: true,
                writable: true,
                enumerable: true,
            };
        }

        var element = {
            kind: def.kind === 'field' ? 'field' : 'method',
            key: key,
            placement: def.static ? 'static' : def.kind === 'field' ? 'own' : 'prototype',
            descriptor: descriptor,
        };
        if (def.decorators) element.decorators = def.decorators;
        if (def.kind === 'field') element.initializer = def.value;
        return element;
    }

    function _coalesceGetterSetter(element, other) {
        if (element.descriptor.get !== undefined) {
            other.descriptor.get = element.descriptor.get;
        } else {
            other.descriptor.set = element.descriptor.set;
        }
    }

    function _coalesceClassElements(elements) {
        var newElements = [];

        var isSameElement = function(other) {
            return (
                other.kind === 'method' &&
                other.key === element.key &&
                other.placement === element.placement
            );
        };

        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            var other;

            if (element.kind === 'method' && (other = newElements.find(isSameElement))) {
                if (_isDataDescriptor(element.descriptor) || _isDataDescriptor(other.descriptor)) {
                    if (_hasDecorators(element) || _hasDecorators(other)) {
                        throw new ReferenceError(
                            'Duplicated methods (' + element.key + ") can't be decorated."
                        );
                    }

                    other.descriptor = element.descriptor;
                } else {
                    if (_hasDecorators(element)) {
                        if (_hasDecorators(other)) {
                            throw new ReferenceError(
                                "Decorators can't be placed on different accessors with for " +
                                    'the same property (' +
                                    element.key +
                                    ').'
                            );
                        }

                        other.decorators = element.decorators;
                    }

                    _coalesceGetterSetter(element, other);
                }
            } else {
                newElements.push(element);
            }
        }

        return newElements;
    }

    function _hasDecorators(element) {
        return element.decorators && element.decorators.length;
    }

    function _isDataDescriptor(desc) {
        return desc !== undefined && !(desc.value === undefined && desc.writable === undefined);
    }

    function _optionalCallableProperty(obj, name) {
        var value = obj[name];

        if (value !== undefined && typeof value !== 'function') {
            throw new TypeError("Expected '" + name + "' to be a function");
        }

        return value;
    }

    function _classPrivateMethodGet(receiver, privateSet, fn) {
        if (!privateSet.has(receiver)) {
            throw new TypeError('attempted to get private field on non-instance');
        }

        return fn;
    }

    function _classPrivateMethodSet() {
        throw new TypeError('attempted to reassign private method');
    }

    function _wrapRegExp(re, groups) {
        _wrapRegExp = function(re, groups) {
            return new BabelRegExp(re, groups);
        };

        var _RegExp = _wrapNativeSuper(RegExp);

        var _super = RegExp.prototype;

        var _groups = new WeakMap();

        function BabelRegExp(re, groups) {
            var _this = _RegExp.call(this, re);

            _groups.set(_this, groups);

            return _this;
        }

        _inherits(BabelRegExp, _RegExp);

        BabelRegExp.prototype.exec = function(str) {
            var result = _super.exec.call(this, str);

            if (result) result.groups = buildGroups(result, this);
            return result;
        };

        BabelRegExp.prototype[Symbol.replace] = function(str, substitution) {
            if (typeof substitution === 'string') {
                var groups = _groups.get(this);

                return _super[Symbol.replace].call(
                    this,
                    str,
                    substitution.replace(/\$<([^>]+)>/g, function(_, name) {
                        return '$' + groups[name];
                    })
                );
            } else if (typeof substitution === 'function') {
                var _this = this;

                return _super[Symbol.replace].call(this, str, function() {
                    var args = [];
                    args.push.apply(args, arguments);

                    if (typeof args[args.length - 1] !== 'object') {
                        args.push(buildGroups(args, _this));
                    }

                    return substitution.apply(this, args);
                });
            } else {
                return _super[Symbol.replace].call(this, str, substitution);
            }
        };

        function buildGroups(result, re) {
            var g = _groups.get(re);

            return Object.keys(g).reduce(function(groups, name) {
                groups[name] = result[g[name]];
                return groups;
            }, Object.create(null));
        }

        return _wrapRegExp.apply(this, arguments);
    }

    var MARKUP_RECT = ['x', 'y', 'left', 'top', 'right', 'bottom', 'width', 'height'];

    var toOptionalFraction = function toOptionalFraction(value) {
        return typeof value === 'string' && /%/.test(value) ? parseFloat(value) / 100 : value;
    };

    // adds default markup properties, clones markup
    var prepareMarkup = function prepareMarkup(markup) {
        var _markup = _slicedToArray(markup, 2),
            type = _markup[0],
            props = _markup[1];

        var rect = props.points
            ? {}
            : MARKUP_RECT.reduce(function(prev, curr) {
                  prev[curr] = toOptionalFraction(props[curr]);
                  return prev;
              }, {});

        return [
            type,
            Object.assign(
                {
                    zIndex: 0,
                },
                props,
                rect
            ),
        ];
    };

    var getImageSize = function getImageSize(file) {
        return new Promise(function(resolve, reject) {
            var imageElement = new Image();
            imageElement.src = URL.createObjectURL(file);

            // start testing size
            var measure = function measure() {
                var width = imageElement.naturalWidth;
                var height = imageElement.naturalHeight;
                var hasSize = width && height;
                if (!hasSize) return;

                URL.revokeObjectURL(imageElement.src);
                clearInterval(intervalId);
                resolve({ width: width, height: height });
            };

            imageElement.onerror = function(err) {
                URL.revokeObjectURL(imageElement.src);
                clearInterval(intervalId);
                reject(err);
            };

            var intervalId = setInterval(measure, 1);

            measure();
        });
    };

    /**
     * Polyfill Edge and IE when in Browser
     */
    if (typeof window !== 'undefined' && typeof window.document !== 'undefined') {
        if (!HTMLCanvasElement.prototype.toBlob) {
            Object.defineProperty(HTMLCanvasElement.prototype, 'toBlob', {
                value: function value(cb, type, quality) {
                    var canvas = this;
                    setTimeout(function() {
                        var dataURL = canvas.toDataURL(type, quality).split(',')[1];
                        var binStr = atob(dataURL);
                        var index = binStr.length;
                        var data = new Uint8Array(index);
                        while (index--) {
                            data[index] = binStr.charCodeAt(index);
                        }
                        cb(new Blob([data], { type: type || 'image/png' }));
                    });
                },
            });
        }
    }

    var isBrowser = typeof window !== 'undefined' && typeof window.document !== 'undefined';
    var isIOS = isBrowser && /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    /**
     * Image Transform Plugin
     */
    var plugin = function plugin(_ref) {
        var addFilter = _ref.addFilter,
            utils = _ref.utils;
        var Type = utils.Type,
            forin = utils.forin,
            getFileFromBlob = utils.getFileFromBlob,
            isFile = utils.isFile;

        /**
         * Helper functions
         */

        // valid transforms (in correct order)
        var TRANSFORM_LIST = ['crop', 'resize', 'filter', 'markup', 'output'];

        var createVariantCreator = function createVariantCreator(updateMetadata) {
            return function(transform, file, metadata) {
                return transform(file, updateMetadata ? updateMetadata(metadata) : metadata);
            };
        };

        var isDefaultCrop = function isDefaultCrop(crop) {
            return (
                crop.aspectRatio === null &&
                crop.rotation === 0 &&
                crop.zoom === 1 &&
                crop.center &&
                crop.center.x === 0.5 &&
                crop.center.y === 0.5 &&
                crop.flip &&
                crop.flip.horizontal === false &&
                crop.flip.vertical === false
            );
        };

        /**
         * Filters
         */
        addFilter('SHOULD_PREPARE_OUTPUT', function(shouldPrepareOutput, _ref2) {
            var query = _ref2.query;
            return new Promise(function(resolve) {
                // If is not async should prepare now
                resolve(!query('IS_ASYNC'));
            });
        });

        var shouldTransformFile = function shouldTransformFile(query, file, item) {
            return new Promise(function(resolve) {
                if (
                    !query('GET_ALLOW_IMAGE_TRANSFORM') ||
                    item.archived ||
                    !isFile(file) ||
                    !isImage(file)
                ) {
                    return resolve(false);
                }

                // if size can't be read this browser doesn't support image
                getImageSize(file)
                    .then(function() {
                        var fn = query('GET_IMAGE_TRANSFORM_IMAGE_FILTER');
                        if (fn) {
                            var filterResult = fn(file);
                            if (filterResult == null) {
                                // undefined or null
                                return handleRevert(true);
                            }
                            if (typeof filterResult === 'boolean') {
                                return resolve(filterResult);
                            }
                            if (typeof filterResult.then === 'function') {
                                return filterResult.then(resolve);
                            }
                        }

                        resolve(true);
                    })
                    .catch(function(err) {
                        resolve(false);
                    });
            });
        };

        addFilter('DID_CREATE_ITEM', function(item, _ref3) {
            var query = _ref3.query,
                dispatch = _ref3.dispatch;
            if (!query('GET_ALLOW_IMAGE_TRANSFORM')) return;

            item.extend('requestPrepare', function() {
                return new Promise(function(resolve, reject) {
                    dispatch(
                        'REQUEST_PREPARE_OUTPUT',
                        {
                            query: item.id,
                            item: item,
                            success: resolve,
                            failure: reject,
                        },

                        true
                    );
                });
            });
        });

        // subscribe to file transformations
        addFilter('PREPARE_OUTPUT', function(file, _ref4) {
            var query = _ref4.query,
                item = _ref4.item;
            return new Promise(function(resolve) {
                shouldTransformFile(query, file, item).then(function(shouldTransform) {
                    // no need to transform, exit
                    if (!shouldTransform) return resolve(file);

                    // get variants
                    var variants = [];

                    // add original file
                    if (query('GET_IMAGE_TRANSFORM_VARIANTS_INCLUDE_ORIGINAL')) {
                        variants.push(function() {
                            return new Promise(function(resolve) {
                                resolve({
                                    name: query('GET_IMAGE_TRANSFORM_VARIANTS_ORIGINAL_NAME'),
                                    file: file,
                                });
                            });
                        });
                    }

                    // add default output version if output default set to true or if no variants defined
                    if (query('GET_IMAGE_TRANSFORM_VARIANTS_INCLUDE_DEFAULT')) {
                        variants.push(function(transform, file, metadata) {
                            return new Promise(function(resolve) {
                                transform(file, metadata).then(function(file) {
                                    return resolve({
                                        name: query('GET_IMAGE_TRANSFORM_VARIANTS_DEFAULT_NAME'),

                                        file: file,
                                    });
                                });
                            });
                        });
                    }

                    // get other variants
                    var variantsDefinition = query('GET_IMAGE_TRANSFORM_VARIANTS') || {};
                    forin(variantsDefinition, function(key, fn) {
                        var createVariant = createVariantCreator(fn);
                        variants.push(function(transform, file, metadata) {
                            return new Promise(function(resolve) {
                                createVariant(transform, file, metadata).then(function(file) {
                                    return resolve({ name: key, file: file });
                                });
                            });
                        });
                    });

                    // output format (quality 0 => 100)
                    var qualityAsPercentage = query('GET_IMAGE_TRANSFORM_OUTPUT_QUALITY');
                    var qualityMode = query('GET_IMAGE_TRANSFORM_OUTPUT_QUALITY_MODE');
                    var quality = qualityAsPercentage === null ? null : qualityAsPercentage / 100;
                    var type = query('GET_IMAGE_TRANSFORM_OUTPUT_MIME_TYPE');
                    var clientTransforms =
                        query('GET_IMAGE_TRANSFORM_CLIENT_TRANSFORMS') || TRANSFORM_LIST;

                    // update transform metadata object
                    item.setMetadata(
                        'output',
                        {
                            type: type,
                            quality: quality,
                            client: clientTransforms,
                        },

                        true
                    );

                    // the function that is used to apply the file transformations
                    var transform = function transform(file, metadata) {
                        return new Promise(function(resolve, reject) {
                            var filteredMetadata = Object.assign({}, metadata);

                            Object.keys(filteredMetadata)
                                .filter(function(instruction) {
                                    return instruction !== 'exif';
                                })
                                .forEach(function(instruction) {
                                    // if not in list, remove from object, the instruction will be handled by the server
                                    if (clientTransforms.indexOf(instruction) === -1) {
                                        delete filteredMetadata[instruction];
                                    }
                                });
                            var resize = filteredMetadata.resize,
                                exif = filteredMetadata.exif,
                                output = filteredMetadata.output,
                                crop = filteredMetadata.crop,
                                filter = filteredMetadata.filter,
                                markup = filteredMetadata.markup;

                            var instructions = {
                                image: {
                                    orientation: exif ? exif.orientation : null,
                                },

                                output:
                                    output &&
                                    (output.type ||
                                        typeof output.quality === 'number' ||
                                        output.background)
                                        ? {
                                              type: output.type,
                                              quality:
                                                  typeof output.quality === 'number'
                                                      ? output.quality * 100
                                                      : null,
                                              background:
                                                  output.background ||
                                                  query(
                                                      'GET_IMAGE_TRANSFORM_CANVAS_BACKGROUND_COLOR'
                                                  ) ||
                                                  null,
                                          }
                                        : undefined,
                                size:
                                    resize && (resize.size.width || resize.size.height)
                                        ? Object.assign(
                                              {
                                                  mode: resize.mode,
                                                  upscale: resize.upscale,
                                              },
                                              resize.size
                                          )
                                        : undefined,
                                crop:
                                    crop && !isDefaultCrop(crop)
                                        ? Object.assign(
                                              {},

                                              crop
                                          )
                                        : undefined,
                                markup: markup && markup.length ? markup.map(prepareMarkup) : [],
                                filter: filter,
                            };

                            if (instructions.output) {
                                // determine if file type will change
                                var willChangeType = output.type
                                    ? // type set
                                      output.type !== file.type
                                    : // type not set
                                      false;

                                var canChangeQuality = /\/jpe?g$/.test(file.type);
                                var willChangeQuality =
                                    output.quality !== null
                                        ? // quality set
                                          canChangeQuality && qualityMode === 'always'
                                        : // quality not set
                                          false;

                                // determine if file data will be modified
                                var willModifyImageData = !!(
                                    instructions.size ||
                                    instructions.crop ||
                                    instructions.filter ||
                                    willChangeType ||
                                    willChangeQuality
                                );

                                // if we're not modifying the image data then we don't have to modify the output
                                if (!willModifyImageData) return resolve(file);
                            }

                            var options = {
                                beforeCreateBlob: query('GET_IMAGE_TRANSFORM_BEFORE_CREATE_BLOB'),
                                afterCreateBlob: query('GET_IMAGE_TRANSFORM_AFTER_CREATE_BLOB'),
                                canvasMemoryLimit: query('GET_IMAGE_TRANSFORM_CANVAS_MEMORY_LIMIT'),
                                stripImageHead: query(
                                    'GET_IMAGE_TRANSFORM_OUTPUT_STRIP_IMAGE_HEAD'
                                ),
                            };

                            transformImage(file, instructions, options)
                                .then(function(blob) {
                                    // set file object
                                    var out = getFileFromBlob(
                                        blob,
                                        // rename the original filename to match the mime type of the output image
                                        renameFileToMatchMimeType(
                                            file.name,
                                            getValidOutputMimeType(blob.type)
                                        )
                                    );

                                    resolve(out);
                                })
                                .catch(reject);
                        });
                    };

                    // start creating variants
                    var variantPromises = variants.map(function(create) {
                        return create(transform, file, item.getMetadata());
                    });

                    // wait for results
                    Promise.all(variantPromises).then(function(files) {
                        // if single file object in array, return the single file object else, return array of
                        resolve(
                            files.length === 1 && files[0].name === null
                                ? // return the File object
                                  files[0].file
                                : // return an array of files { name:'name', file:File }
                                  files
                        );
                    });
                });
            });
        });

        // Expose plugin options
        return {
            options: {
                allowImageTransform: [true, Type.BOOLEAN],

                // filter images to transform
                imageTransformImageFilter: [null, Type.FUNCTION],

                // null, 'image/jpeg', 'image/png'
                imageTransformOutputMimeType: [null, Type.STRING],

                // null, 0 - 100
                imageTransformOutputQuality: [null, Type.INT],

                // set to false to copy image exif data to output
                imageTransformOutputStripImageHead: [true, Type.BOOLEAN],

                // only apply transforms in this list
                imageTransformClientTransforms: [null, Type.ARRAY],

                // only apply output quality when a transform is required
                imageTransformOutputQualityMode: ['always', Type.STRING],
                // 'always'
                // 'optional'
                // 'mismatch' (future feature, only applied if quality differs from input)

                // get image transform variants
                imageTransformVariants: [null, Type.OBJECT],

                // should we post the default transformed file
                imageTransformVariantsIncludeDefault: [true, Type.BOOLEAN],

                // which name to prefix the default transformed file with
                imageTransformVariantsDefaultName: [null, Type.STRING],

                // should we post the original file
                imageTransformVariantsIncludeOriginal: [false, Type.BOOLEAN],

                // which name to prefix the original file with
                imageTransformVariantsOriginalName: ['original_', Type.STRING],

                // called before creating the blob, receives canvas, expects promise resolve with canvas
                imageTransformBeforeCreateBlob: [null, Type.FUNCTION],

                // expects promise resolved with blob
                imageTransformAfterCreateBlob: [null, Type.FUNCTION],

                // canvas memory limit
                imageTransformCanvasMemoryLimit: [
                    isBrowser && isIOS ? 4096 * 4096 : null,
                    Type.INT,
                ],

                // background image of the output canvas
                imageTransformCanvasBackgroundColor: [null, Type.STRING],
            },
        };
    };

    // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
    if (isBrowser) {
        document.dispatchEvent(new CustomEvent('FilePond:pluginloaded', { detail: plugin }));
    }

    return plugin;
});
